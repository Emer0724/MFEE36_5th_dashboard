<?php
// require './parts/admin-required.php';
require './parts/connection.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = " DELETE FROM forum_category WHERE sid={$sid}";

$pdo->query($sql);

$comeFrom = 'category.php';
if(! empty($_SERVER['HTTP_REFERER'])){
    $comeFrom = $_SERVER['HTTP_REFERER'];
}


header('Location: '. $comeFrom);
