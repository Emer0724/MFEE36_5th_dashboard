<?php
// require './parts/admin-required.php';
require '../parts/db-connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = " DELETE FROM address_book WHERE sid={$sid}";

$pdo->query($sql);

$comeFrom = 'list.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}

header('Location: ' . $comeFrom);//停留在刪除的頁面
