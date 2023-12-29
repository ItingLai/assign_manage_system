<?php
//確認薪資項目，取得所有人當月薪資api
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
require_once './authUserType/boss_accountant.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if(!isset($_GET['month'])){
        $res=json_encode(['code'=>500,'msg'=>'Params missing!']);
        exit($res);
    }
    $date=$_GET['month'].'-01';
    $sql='SELECT name,attend,personal,sick,official,absent,not_entry AS notEntry,basic,perfect_attend_bonus AS perfectAttend,sick_personal_deduction,not_entry_deduction AS notEntry_deduction,dock,labor_health AS laborHealthInsurance,total,is_check as isCheck FROM salaryinfo WHERE `month`=?';
    $result=$pdo->prepare($sql);
    $data=[$date];
    if($result->execute($data)){
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        $isCheck=true;
        foreach ($result as $value){
            if($value['isCheck']==0){
                $isCheck=false;
            }
        }
        if(count($result)==0){
            $isCheck=false;
        }
        $res=json_encode(['code'=>200,'data'=>$result,'isCheck'=>$isCheck]);
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