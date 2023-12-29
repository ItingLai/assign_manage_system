<?php
if(!isset($_SESSION['isLogin'])&&@$_SESSION['isLogin']!==true){
    $res=json_encode(['code'=>401,'msg'=>'Not Login!']);
    exit($res);
}
?>