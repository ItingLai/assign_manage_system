<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
if($_SERVER['REQUEST_METHOD']==="GET"){

    if(isset($_GET['month'])){
        $start_date = $_GET['month'].'-'."01";
        $end_date = $_GET['month'].'-'.date("t",strtotime($start_date));
    }else{
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d', strtotime("$start_date +1 month -1 day"));
    }
    $sql='SELECT `date` AS `start`,`date` AS `end`,IF(remark="","休假",remark) AS title,"dayOff" AS `type` FROM calendar WHERE date>=? AND date<=? AND `type`="dayOff" UNION ALL SELECT `start`,`end`,`title`,"announcement" AS `type` FROM announcement WHERE start>=? AND start<=? ORDER BY `start`' ;
    $result=$pdo->prepare($sql);
    $data=[$start_date,$end_date,$start_date,$end_date];
    if($result->execute($data)){
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        $res=json_encode(['code'=>200,'data'=>$result]);
        echo $res;
    }else{
        $res=json_encode(['code'=>500,'msg'=>'Error!']);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>