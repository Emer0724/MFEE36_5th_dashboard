<?php

// require '../parts/admin-required.php';
require '../parts/connect-db.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
    'name' => []
];


$email = $_POST['email'];
$stmt = $pdo->prepare('SELECT * FROM member WHERE email = ?');
$stmt->execute([$email]);

if($stmt->rowCount() > 0) {
    echo 'taken';
} else {
    echo 'not_taken';
}
