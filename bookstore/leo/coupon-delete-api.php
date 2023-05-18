<?php
// require './parts/admin-required.php';
require '../parts/db-connect.php';

$couponID = isset($_GET['couponID']) ? intval($_GET['couponID']) : 0;

$sql = " DELETE FROM coupon WHERE couponID={$couponID}";

$pdo->query($sql);

$comeFrom = 'coupon.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}

header('Location: ' . $comeFrom);
