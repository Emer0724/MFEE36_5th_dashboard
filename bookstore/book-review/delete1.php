<?php

require '../parts/db-connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = " DELETE FROM book_comment WHERE sid={$sid}";

$pdo->query($sql);

$comeFrom = 'book-review.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}


header('Location: book-review.php');
