<?php
require '../parts/admin-required.php';
require '../parts/connect-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = " UPDATE `member` SET`status`=?, `updated`=? WHERE sid={$sid}";

date_default_timezone_set('Asia/Taipei');
$today = date("Y-m-d H:i:s");

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ''
]);

$comeFrom = 'list-admin.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}

header('Location: ' . $comeFrom);//停留在刪除的頁面