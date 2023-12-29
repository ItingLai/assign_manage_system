<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';//判斷登入
require_once './authUserType/personal.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    $response=json_decode(file_get_contents('php://input'),true);
    if(isset($response['userId'])&&isset($response['attendType'])&&isset($response['start'])&&isset($response['end'])){
        $datediff=round((strtotime($response['end'])-strtotime($response['start']))/3600/24);//判斷是否是多天的
        if($datediff>0){
            //如果有多天的話,因為fullcalendar多天顯示必須截止日比實際日多一天，所以這邊就-1天防止抓不到資料
            $response['end']=date('Y-m-d',strtotime('-1 day',strtotime($response['end'])));
        }
        if($response['attendType']==='attend'){
            $sql='DELETE FROM `leave` WHERE user_id=? AND start=? AND end=?';
            $data=[$response['userId'],$response['start'],$response['end']];
        }else{
            $sql='SELECT * FROM `leave` WHERE user_id=? AND start=? AND end=?';
            $data=[$response['userId'],$response['start'],$response['end']];
            $result=$pdo->prepare($sql);
            if($result->execute($data)){
                $result=$result->fetchAll(PDO::FETCH_ASSOC);
                if(count($result)>0){
                    $sql='UPDATE `leave` SET type=? WHERE user_id=? AND start=? AND end=?';
                    $data=[$response['attendType'],$response['userId'],$response['start'],$response['end']];
                }else{
                    $sql='SELECT name FROM user WHERE id=?';
                    $data=[$response['userId']];
                    $result=$pdo->prepare($sql);
                    if($result->execute($data)){
                        $result=$result->fetchAll(PDO::FETCH_ASSOC);
                    }else{
                        $res=json_encode(['code'=>500,'msg'=>'Error!']);
                        exit($res);
                    }
                    $sql='INSERT INTO `leave` (user_id,date,start,end,name,type,reason,status,add_type) VALUES (?,?,?,?,?,?,?,?,"system")';
                    $data=[$response['userId'],date('Y-m-d'),$response['start'],$response['end'],$result[0]['name'],$response['attendType'],'人事手動新增',1];
                }
            }else{
                $res=json_encode(['code'=>500,'msg'=>'Error!']);
                exit($res);
            }
        }
        $result=$pdo->prepare($sql);
        if($result->execute($data)){
            $res=json_encode(['code'=>200]);
            exit($res);
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