<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/personal_boss.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['option'])){
        switch ($response['option']){
            case 'add':
                if(isset($response['data']['username'])&&isset($response['data']['name'])&&isset($response['data']['telephone'])&&isset($response['data']['address'])&&isset($response['data']['type'])&&isset($response['data']['basicSalary'])){
                    $sql='SELECT username FROM user WHERE username=?';
                    $data=[$response['data']['username']];
                    $result=$pdo->prepare($sql);
                    if($result->execute($data)){
                        $result=$result->fetchAll(PDO::FETCH_ASSOC);
                        if(count($result)>0){
                            $res=json_encode(['code'=>400,'msg'=>'User Exists!']);
                            exit($res);
                        }
                    }else{
                        $res=json_encode(['code'=>500,'msg'=>'Error!']);
                        exit($res);
                    }
                    $sql='INSERT INTO user (type,username,password,name,telephone,address,basic_salary) VALUES (?,?,?,?,?,?,?)';
                    $data=[$response['data']['type'],$response['data']['username'],password_hash($response['data']['telephone'],PASSWORD_DEFAULT),$response['data']['name'],$response['data']['telephone'],$response['data']['address'],$response['data']['basicSalary']];
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'Params Not Found!']);
                    exit($res);
                }
                break;
            case 'delete':
                if(isset($response['userId'])){
                    $sql='DELETE FROM user WHERE id=?';
                    $data=[$response['userId']];
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'Params Not Found!']);
                    exit($res);
                }
                break;
            case 'edit':
                if(isset($response['data']['id'])&&isset($response['data']['username'])&&isset($response['data']['name'])&&isset($response['data']['telephone'])&&isset($response['data']['address'])&&isset($response['data']['type'])&&isset($response['data']['basicSalary'])){
                    $sql='UPDATE user SET type=?,username=?,name=?,telephone=?,address=?,basic_salary=? WHERE id=?';
                    $data=[$response['data']['type'],$response['data']['username'],$response['data']['name'],$response['data']['telephone'],$response['data']['address'],$response['data']['basicSalary'],$response['data']['id']];
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'Params Not Found!']);
                    exit($res);
                }
                break;
            case 'resetPassword':
                if(isset($response['userId'])){
                    $sql='SELECT telephone FROM user WHERE id=?';
                    $data=[$response['userId']];
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'Params Not Found!']);
                    exit($res);
                }
                break;
            default:
                $res=json_encode(['code'=>500,'msg'=>'option Not Found!']);
                exit($res);
        }
        $result=$pdo->prepare($sql);
        if($result->execute($data)){
            if($response['option']==='add'){
                $lastId=$pdo->lastInsertId();
                $sql='SELECT id,type,username,name,telephone,address,basic_salary as basicSalary FROM user WHERE id=?';
                $data=[$lastId];
                $result=$pdo->prepare($sql);
                if($result->execute($data)){
                    $result=$result->fetchAll(PDO::FETCH_ASSOC);
                    $result=$result[0];
                    $res=json_encode(['code'=>200,'data'=>$result]);
                    echo $res;
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'Cannot Find Id!']);
                    echo $res;
                }
            }elseif($response['option']==='resetPassword'){
                $result=$result->fetchAll(PDO::FETCH_ASSOC);
                $sql='UPDATE user SET password=? WHERE id=?';
                $data=[password_hash($result[0]['telephone'],PASSWORD_DEFAULT),$response['userId']];
                $result=$pdo->prepare($sql);
                if($result->execute($data)){
                    $res=json_encode(['code'=>200]);
                    echo $res;
                }else{
                    $res=json_encode(['code'=>500,'msg'=>'Error!']);
                    echo $res;
                }
            }else{
                $res=json_encode(['code'=>200]);
                echo $res;
            }
        }else{
            $res=json_encode(['code'=>500,'msg'=>'option Not Found!']);
            echo $res;
        }
    }else{
        $res=json_encode(['code'=>500,'msg'=>'option Not Found!']);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}
?>