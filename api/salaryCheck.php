<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
require_once './authUserType/accountant.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['month'])){
        $date=$response['month'].'-01';
        $sql='UPDATE salaryinfo SET is_check=? WHERE month=?';
        $data=[1,$date];
        $result=$pdo->prepare($sql);
        if($result->execute($data)){
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