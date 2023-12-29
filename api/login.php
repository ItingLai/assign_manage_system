<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
if(isset($_SESSION['isLogin'])&&$_SESSION['isLogin']==true){
    $res=json_encode(['code'=>500,'msg'=>'Already Login']);
    exit($res);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['username'])&&isset($response['password'])){
        $sql='SELECT * FROM user WHERE username=?';
        $data=[$response['username']];
        $result=$pdo->prepare($sql);
        if ($result->execute($data)){
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)==1){
                $result=$result[0];
                if(password_verify($response['password'],$result['password'])){
                    $res=json_encode(['code'=>200,'data'=>['name'=>$result['name'],'type'=>$result['type']]]);
                    $_SESSION['isLogin']=true;
                    $_SESSION['userId']=$result['id'];
                    $_SESSION['userType']=$result['type'];
                }else{
                    $res=json_encode(['code'=>401,'msg'=>'Wrong Password!']);
                }
                echo $res;
            }else{
                $res=json_encode(['code'=>401,'msg'=>'User Not Found!']);
                echo $res;
            }
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