<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/personal_manager_boss.php';
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['leave_id'])&&isset($response['user_id'])&&isset($response['type'])&&isset($response['reason'])){
        $sql='UPDATE `leave` SET `status`=?,`not_agree_reason`=? WHERE id=? AND user_id=?';
        $result=$pdo->prepare($sql);
        $data=[$response['type']==='agree'?1:0,$response['reason'],$response['leave_id'],$response['user_id']];
        if($result->execute($data)){
            $res=json_encode(['code'=>200]);
            exit($res);
        }else{
            $res=json_encode(['code'=>500,'msg'=>'Update Data Error!!']);
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