<?php
// require './parts/admin-required.php';
require '../parts/db-connect.php';

$ISBN = isset($_GET['ISBN']) ? intval($_GET['ISBN']) : 0;

$sql = " DELETE FROM book_info WHERE ISBN={$ISBN}";

$pdo->query($sql);

$comeFrom = 'market.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}

header('Location: ' . $comeFrom);
