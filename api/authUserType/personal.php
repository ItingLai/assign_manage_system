<?php
    if(!isset($_SESSION['userType'])||@$_SESSION['userType']!=='personal'){
        $res=json_encode(['code'=>401,'msg'=>'Identity Error!']);
        exit($res);
    }
?>
