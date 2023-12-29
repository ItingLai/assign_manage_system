<?php
header('Content-type: application/json');
session_start();
    if(isset($_SESSION['isLogin'])&&$_SESSION['isLogin']===true){
        session_destroy();
        $res=json_encode(['code'=>200]);
        echo $res;
    }else{
        $res=json_encode(['code'=>401]);
        echo $res;
    }
?>