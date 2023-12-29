<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['originalPw'])&&isset($response['password'])&&isset($response['confirmPw'])){
        if($response['password']===$response['confirmPw']){
            $sql='SELECT password FROM user WHERE id=?';
            $data=[$_SESSION['userId']];
            $result=$pdo->prepare($sql);
            if($result->execute($data)){
                $result=$result->fetchAll(PDO::FETCH_ASSOC);
                if(password_verify($response['originalPw'],$result[0]['password'])){
                    $sql='UPDATE user SET password=? WHERE id=?';
                    $data=[password_hash($response['password'],PASSWORD_DEFAULT),$_SESSION['userId']];
                    $result=$pdo->prepare($sql);
                    if($result->execute($data)){
                        session_destroy();
                        $res=json_encode(['code'=>200]);
                        echo $res;
                    }else{
                        $res=json_encode(['code'=>500,'msg'=>'Error!']);
                        echo $res;
                    }
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'original Password Incorrect!']);
                    echo $res;
                }
            }else{
                $res=json_encode(['code'=>500,'msg'=>'Error!']);
                echo $res;
            }
        }else{
            $res=json_encode(['code'=>500,'msg'=>'Two Password not the same!']);
            echo $res;
        }
    }else{
        $res=json_encode(['code'=>500,'msg'=>'Params missing!']);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>