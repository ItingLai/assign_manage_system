<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/personal_manager_boss.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if($_SESSION['userType']==='boss'){
        $sql='SELECT id as leave_id,user_id,date,start,end,name,type,reason FROM `leave` WHERE status IS NULL';
        $data=[];
    }elseif($_SESSION['userType']==='personal'){
        $sql='SELECT leave.id as leave_id,leave.user_id,user.id,leave.date,leave.start,leave.end,leave.name,leave.type,leave.reason FROM `leave` INNER JOIN user on user.id=leave.user_id WHERE user.type!=? AND status IS NULL';
        $data=['personal'];
    }else{
        $sql='SELECT leave.id as leave_id,leave.user_id,user.id,leave.date,leave.start,leave.end,leave.name,leave.type,leave.reason FROM `leave` INNER JOIN user on user.id=leave.user_id WHERE user.type!=? AND user.type!=? AND user.type!=? AND status IS NULL';
        $data=['manager','personal','accountant'];
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