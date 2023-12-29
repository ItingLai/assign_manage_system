<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
require_once './authUserType/personal.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if(isset($_GET['userId'])&&isset($_GET['month'])){
        $start_date = $_GET['month'].'-'."01";
        $end_date1 = $_GET['month'].'-'.date("t",strtotime($start_date));
        $end_date2=date('Y-m-d');
        $end_date=strtotime($end_date2)>strtotime($end_date1)?$end_date1:$end_date2;
        $sql='SELECT date as `start`,date as `end`,type ,remark as title FROM `calendar` WHERE date>=? AND date<=?';
        $sql2='SELECT start,end,type,"" as title FROM `leave` WHERE start>=? AND end<=? AND user_id=? AND `leave`.status IS NOT NULL AND `leave`.status!=0';
        $result=$pdo->prepare($sql);
        $result2=$pdo->prepare($sql2);
        $data=[$start_date,$end_date];
        $data2=[$start_date,$end_date,$_GET['userId']];
        if($result->execute($data)&&$result2->execute($data2)){
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            $result2=$result2->fetchAll(PDO::FETCH_ASSOC);
            $r=[];
            $datediff=0;
            foreach ($result as $value){
                foreach ($result2 as $value2){
                    if($value2['start']===$value['start']){
                        $datediff=round((strtotime($value2['end'])-strtotime($value2['start']))/3600/24)+1;//+1是為了防止一筆資料被添加兩次，如果是天數一天就為0，if就會push一次，迴圈結束push一次
                        $value['start']=$value2['start'];
                        $value['type']=$value2['type'];
                        $value['title']=$value2['title'];
                        #$value['end']=date('Y-m-d',strtotime('+1 day',strtotime($value2['end'])));
                        //如果開始結束同一天就代表請一天假，不同天的話因為fullcalendar預設多天會顯示到end的前一天，必須+1day顯示才會正常
                        $value['end']=strtotime($value2['end'])==strtotime($value2['start'])?$value2['end']:date('Y-m-d',strtotime('+1 day',strtotime($value2['end'])));
                        array_push($r,$value);
                    }
                }
                if($datediff==0){
                    array_push($r,$value);
                }else{
                    $datediff-=1;
                }
            }
            $res=json_encode(['code'=>200,'data'=>$r]);
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