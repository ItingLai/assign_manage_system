<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if(isset($_GET['month'])){
        $start_date = $_GET['month'].'-'."01";
        $end_date1 = $_GET['month'].'-'.date("t",strtotime($start_date));
        $end_date2=date('Y-m-d');
        #$end_date=strtotime($end_date2)>strtotime($end_date1)?$end_date1:$end_date2;//
        $end_date=$end_date1;
        //如果create_dt日期大於當前月份的話，代表在看歷史班表，在入職時間前有排班表不合理，故要做篩選，讓create_dt>當前月份時過濾掉
        $sql='SELECT name,DATE,type FROM attend_data WHERE `date`>=? AND `date`<=? AND create_dt<=?';
        $data=[$start_date,$end_date,$end_date];
        $result=$pdo->prepare($sql);
        if($result->execute($data)){
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            $res=json_encode(['code'=>200,'data'=>$result]);
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