<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    if(isset($_SESSION['isLogin'])&&@$_SESSION['isLogin']===true){
        $sql='SELECT type,name FROM user WHERE id=?';
        $result=$pdo->prepare($sql);
        $data=[$_SESSION['userId']];
        if($result->execute($data)){
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            $result=$result[0];
            $res=json_encode(['code'=>200,'data'=>$result]);
            echo $res;
        }else{
            $res=json_encode(['code'=>500]);
            echo $res;
        }
    }else{
        $res=json_encode(['code'=>401]);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>