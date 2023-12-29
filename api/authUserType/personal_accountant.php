<?php
    if(!isset($_SESSION['userType'])||(@$_SESSION['userType']!=='personal'&&@$_SESSION['userType']!=='accountant')){
        $res=json_encode(['code'=>401,'msg'=>'Identity Error!']);
        exit($res);
    }
?>
