<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
require_once 'isLogin.php';
require_once './authUserType/personal.php';
$pdo=require_once 'config.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_FILES['file'])){
        if($_FILES['file']['type']!='text/csv'){
            $res=json_encode(['code'=>500,'msg'=>'File Type Error!']);
            exit($res);
        }
        $file=$_FILES['file'];
        $fp=fopen($file['tmp_name'],'r');
        $tmp=0;
        while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
            if($tmp!=0){
                $date = $data[0];
                $type = $data[2]=='2'?'dayOff':'attend';
                $remark=mb_convert_encoding($data[3], "UTF-8","Big-5");
                $sql='INSERT INTO calendar (date,type,remark) VALUES (?,?,?)';
                $result=$pdo->prepare($sql);
                $data=[$date,$type,$remark];
                if(!$result->execute($data)){
                    $res=json_encode(['code'=>500,'msg'=>'Date Data exist!']);
                    exit($res);
                }
            }else{
                $tmp+=1;
            }
        }
        $sql='DELETE FROM calendar WHERE date<?';
        $data=[date('Y-01-01', strtotime('-1 year'))];
        $result=$pdo->prepare($sql);
        if($result->execute($data)){
            $res=json_encode(['code'=>200]);
            exit($res);
        }else{
            $res=json_encode(['code'=>200,'msg'=>'historyData Delete Error!']);
            exit($res);
        }
    }else{
        $res=json_encode(['code'=>500,'msg'=>'File Not Found!']);
        echo $res;
    }
}else{
    $res=json_encode(['code'=>405,'msg'=>'Method Not Allow!']);
    echo $res;
}

?>