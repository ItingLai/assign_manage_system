<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
require_once './authUserType/personal_accountant.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['month'])){
        $start_date = $response['month'].'-'."01";
        $end_date1 = $response['month'].'-'.date("t",strtotime($start_date));
        $end_date2=date('Y-m-d');
        if(strtotime($end_date2)<strtotime($end_date1)){
            $res=json_encode(['code'=>401,'msg'=>'Current Month Not End!']);
            exit($res);
        }
        $end_date=strtotime($end_date2)>strtotime($end_date1)?$end_date1:$end_date2;
        $sql='SELECT count(*) as days FROM `calendar` WHERE date>=? AND date<=?';
        $sql2='SELECT user.name,user.id,user.basic_salary,
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
            if($result3[0]['count']>0) {
                $sql3 = 'DELETE FROM salaryinfo WHERE month=?';
                $data = [$start_date];
                $result3 = $pdo->prepare($sql3);
                if (!$result3->execute($data)) {
                    $res = json_encode(['code' => 500, 'msg' => 'Please try again!']);
                    exit($res);
                }
            }
            foreach ($result2 as $value2){
                $sql='INSERT INTO salaryinfo (month,user_id,name,attend,personal,official,sick,absent,not_entry,basic,perfect_attend_bonus,sick_personal_deduction,not_entry_deduction,dock,labor_health,total) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $allDays=$result[0]['days'];
                $attendDays=$allDays-$value2['personal']-$value2['official']-$value2['sick']-$value2['absent']-$value2['notEntry'];//出席天數
                $isPerfect=$value2['personal']<=0&&$value2['sick']<=0&&$value2['absent']<=0&&$value2['notEntry']<=0;//是否全勤
                $personal_deduction=$value2['personal']>0?($value2['basic_salary']/30)*$value2['personal']:0;//事假扣薪
                $sick_deduction=$value2['sick']>0?($value2['basic_salary']/30)*$value2['sick']:0;//病假扣薪
                $notEntry_deduction=$value2['notEntry']>0?($value2['basic_salary']/30)*$value2['notEntry']:0;//未入職扣薪
                $sick_personal_deduction=$sick_deduction+$personal_deduction;
                $absent_deduction=$value2['absent']>0?($value2['basic_salary']/30)*$value2['absent']*2:0;//無故缺曠扣薪
                $perfect_attend_bonus=$isPerfect?($value2['basic_salary']/30)*2:0;//全勤獎金
                $total=$value2['basic_salary']+$perfect_attend_bonus-$sick_personal_deduction-$absent_deduction-$notEntry_deduction;//計算總薪資
                $labor_health=round($total*0.12*0.2)+round($total*0.0517*0.3);//以總薪資計算勞健保
                $total=$total-$labor_health;//總薪資=加完的總額-勞健保
                $data=[$start_date,$value2['id'],$value2['name'],$attendDays,$value2['personal'],$value2['official'],$value2['sick'],$value2['absent'],$value2['notEntry'],$value2['basic_salary'],$perfect_attend_bonus,$sick_personal_deduction,$notEntry_deduction,$absent_deduction,$labor_health,$total];
                $result4=$pdo->prepare($sql);
                if(!$result4->execute($data)){
                    $res=json_encode(['code'=>500,'msg'=>'Error!']);
                    exit($res);
                }
            }
            $res=json_encode(['code'=>200]);
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