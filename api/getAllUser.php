<?php
//手動調整出缺席頁面,取得使用者api
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/personal.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    $sql='SELECT id,name FROM user WHERE type!=? AND type!=?';
    $result=$pdo->prepare($sql);
    $data=['boss','personal'];
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