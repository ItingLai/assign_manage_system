<?php
$dbhost = 'db'; //一般是 localhost或127.0.0.1
$dbuser = 'root'; //一般是 root
$dbpasswd = 'admin';
$dbname = 'personal_manage_system';//資料庫名稱
$dbcharacter = 'utf8mb4'; //一般是 utf8

if(!defined('Is_allow')){
    header('HTTP/1.0 404 Not Found');
}else{
    try
    {
        $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname};charset={$dbcharacter}", $dbuser, $dbpasswd);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的模擬效果 不讓web server去拼湊處理語句
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT); //讓資料庫不顯示錯誤原因
        return $pdo;
    } catch (PDOException $e) {
        die("連線失敗：" .$e->getMessage());
        die("連線失敗：" . "請聯絡網站管理員");
    }
}
?>