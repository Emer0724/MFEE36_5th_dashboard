<?php


//用變數開頭,常數也可
$db_host = '173.201.253.251';
$db_name = 'project';
$db_user = 'admin'; //帳號
$db_pass = 'h5MFu8ZVsRrw8PT'; //密碼


$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4"; // data source name




$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];




try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
} catch (PDOException $ex) {
    echo 'Connection failed: ' . $ex->getMessage();
}


if (!isset($_SESSION)) {
    session_start();
}
// 確保只跑一次
