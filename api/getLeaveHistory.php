<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    $sql='SELECT * FROM `leave` WHERE user_id=? AND add_type=? UNION ALL SELECT * FROM `copy_leave` WHERE user_id=? AND add_type=?';
    $data=[$_SESSION['userId'],"user",$_SESSION['userId'],"user"];
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