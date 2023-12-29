<?php
    if(!isset($_SESSION['userType'])||(@$_SESSION['userType']!=='personal'&&@$_SESSION['userType']!=='manager'&&@$_SESSION['userType']!=='boss')){
        $res=json_encode(['code'=>401,'msg'=>'Identity Error!']);
        exit($res);
    }
?>
