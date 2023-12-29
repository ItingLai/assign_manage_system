<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/boss.php';//判斷身分組
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['title'])&&isset($response['date'])){
        $start=date("Y:m:d",strtotime($response['date'][0]));
        $end=date("Y:m:d",strtotime($response['date'][1]));
        $sql='INSERT INTO announcement (title,start,end) VALUES (?,?,?)';
        $result=$pdo->prepare($sql);
        $data=[$response['title'],$start,$end];
        if($result->execute($data)){
            $res=json_encode(['code'=>200]);
            echo $res;
        }else{
            $res=json_encode(['code'=>500,'msg'=>'Error!']);
            echo $res;
        }
    }else{
        $res=json_encode(['code'=>500,'msg'=>'Params Error!']);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>