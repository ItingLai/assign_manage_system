<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
require_once './authUserType/personal_accountant.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if(isset($_GET['month'])){
        $start_date = $_GET['month'].'-'."01";
        $end_date1 = $_GET['month'].'-'.date("t",strtotime($start_date));
        $end_date2=date('Y-m-d');
        $end_date=strtotime($end_date2)>strtotime($end_date1)?$end_date1:$end_date2;
        $sql='SELECT count(*) as days FROM `calendar` WHERE date>=? AND date<=?';
        $sql2='SELECT user.name,
            COALESCE(SUM(CASE WHEN `leave`.type = "personal" THEN DATEDIFF(`leave`.`end`, `leave`.`start`) + 1 ELSE 0 END), 0) AS personal,
	        COALESCE(SUM(CASE WHEN `leave`.type = "official" THEN DATEDIFF(`leave`.`end`, `leave`.`start`) + 1 ELSE 0 END), 0) AS official,
	        COALESCE(SUM(CASE WHEN `leave`.type = "absent" THEN DATEDIFF(`leave`.`end`, `leave`.`start`) + 1 ELSE 0 END), 0) AS absent,
	        COALESCE(SUM(CASE WHEN `leave`.type = "sick" THEN DATEDIFF(`leave`.`end`, `leave`.`start`) + 1 ELSE 0 END), 0) AS sick,
            COALESCE(SUM(CASE WHEN `leave`.type = "notEntry" THEN DATEDIFF(`leave`.`end`, `leave`.`start`) + 1 ELSE 0 END), 0) AS notEntry
            FROM `user` LEFT JOIN `leave` ON user.id = leave.user_id AND `leave`.`start` >= ? AND `leave`.`end` <= ? AND `leave`.`status` IS NOT NULL AND `leave`.`status`!=0 
            WHERE user.type!="boss" AND user.create_dt<=? GROUP BY user.id';
        $sql3='SELECT count(*) as count FROM salaryinfo WHERE month=?';
        $result=$pdo->prepare($sql);
        $result2=$pdo->prepare($sql2);
        $result3=$pdo->prepare($sql3);
        $data1=[$start_date,$end_date];
        $data2=[$start_date,$end_date,$end_date];
        if($result->execute($data1)&&$result2->execute($data2)&&$result3->execute([$start_date])){
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            $result2=$result2->fetchAll(PDO::FETCH_ASSOC);
            $result3=$result3->fetchAll(PDO::FETCH_ASSOC);
            $r=[];
            foreach ($result2 as $value2){
                $allDays=$result[0]['days'];
                $attendDays=$allDays-$value2['personal']-$value2['official']-$value2['sick']-$value2['absent']-$value2['notEntry'];
                $isPerfect=$value2['personal']<=0&&$value2['sick']<=0&&$value2['absent']<=0&&$value2['notEntry']<=0;
                $tmp=['name'=>$value2['name'],'attend'=>$attendDays,'personal'=>$value2['personal'],'official'=>$value2['official'],'sick'=>$value2['sick'],'absent'=>$value2['absent'],'notEntry'=>$value2['notEntry'],'isPerfect'=>$isPerfect];
                array_push($r,$tmp);
            }
            $isCalc=$result3[0]['count']>0;
            $res=json_encode(['code'=>200,'data'=>$r,'isCalc'=>$isCalc]);
            echo $res;
        }else{
            $res=json_encode(['code'=>500,'msg'=>'Error!']);
            echo $res;
        }
    }else{
        $res=json_encode(['code'=>500,'msg'=>'Params Missing!']);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>