<?php
header('Content-type: application/json');
define('Is_allow', true);//授權連線資料庫
session_start();
date_default_timezone_set('Asia/Taipei');
$pdo=require_once 'config.php';
require_once 'isLogin.php';
if($_SERVER['REQUEST_METHOD']==="GET"){
    $date=date('Y-m-01', strtotime('-1 month'));
    $sql='SELECT `month`,name,attend,personal,sick,official,absent,not_entry AS notEntry,basic,perfect_attend_bonus AS perfectAttend,sick_personal_deduction,not_entry_deduction AS notEntry_deduction,dock,labor_health AS laborHealthInsurance,total FROM salaryinfo WHERE user_id=? AND `month`=? AND is_check=?';
    $result=$pdo->prepare($sql);
    $data=[$_SESSION['userId'],$date,1];
    if($result->execute($data)){
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        if(count($result)>0){
            $result=$result[0];
            $result['month']=substr($result['month'],0,7);
        }else{
            $result=['month'=>'尚未結算','name'=>'尚未結算','attend'=> 0,'personal'=> 0,'sick'=> 0,'official'=> 0,'absent'=> 0,'notEntry'=>0,'basic'=> 0,'perfectAttend'=> 0,'sick_personal_deduction'=> 0,'notEntry_deduction'=>0,'dock'=> 0,'laborHealthInsurance'=> 0,'total'=> 0];
        }
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