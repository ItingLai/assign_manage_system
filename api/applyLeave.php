<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['leaveType'])&&isset($response['leaveDate'])&&isset($response['leaveReason'])){
        $start=date('Y-m-d',strtotime($response['leaveDate'][0]));
        $end=date('Y-m-d',strtotime($response['leaveDate'][1]));
        $sql='SELECT name FROM user WHERE id=?';
        $data=[$_SESSION['userId']];
        $result=$pdo->prepare($sql);
        if($result->execute($data)){
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            $name=$result[0]['name'];
            $sql='INSERT INTO `leave` (user_id,date,start,end,name,type,reason,add_type) VALUES (?,?,?,?,?,?,?,"user")';
            $data=[$_SESSION['userId'],date('Y-m-d'),$start,$end,$name,$response['leaveType'],$response['leaveReason']];
            $result=$pdo->prepare($sql);
            if($result->execute($data)){
                $res=json_encode(['code'=>200]);
                exit($res);
            }else{
                $res=json_encode(['code'=>500,'msg'=>'Insert Data Error!']);
                exit($res);
            }
        }else{
            $res=json_encode(['code'=>500,'msg'=>'Error!']);
            exit($res);
        }
    }else{
        $res=json_encode(['code'=>500,'msg'=>'Params missing!']);
        exit($res);
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    exit($res);
}
?>