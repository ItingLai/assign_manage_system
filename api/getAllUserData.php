<?php
//新增使用者頁面，取得所有使用者api
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/personal_boss.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if($_SESSION['userType']==="personal"){
        $sql='SELECT id,type,username,name,telephone,address,basic_salary as basicSalary FROM user WHERE type!=? AND type!=?';
        $data=['boss','personal'];
    }else{
        $sql='SELECT id,type,username,name,telephone,address,basic_salary as basicSalary FROM user WHERE type!=?';
        $data=['boss'];
    }
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
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>