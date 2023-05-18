<?php
// require './parts/admin-required.php';
require '../parts/db-connect.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

$sql = " DELETE FROM orders WHERE order_id={$order_id}";

$pdo->query($sql);

$comeFrom = 'order.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}

header('Location: ' . $comeFrom);
