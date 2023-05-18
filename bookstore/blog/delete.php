<?php

require '../parts/connect-db.php';

$sid = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;

$sql = " DELETE FROM blog WHERE blog_id={$sid}";

$pdo->query($sql);

$comeFrom = 'blog-filter.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}


header('Location: blog-filter.php');
