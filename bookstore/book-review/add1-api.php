<?php
require '../parts/db-connect.php';

$isPass = true;

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => '',
];

$currentDateTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rate = $_POST['rate'];
}

if ($isPass) {
    $sql = "INSERT INTO `book_comment` (`sid`,`ISBN`,`rate`, `created`, `comment`) VALUES (?,?,  ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['sid'],
        $_POST['ISBN'],
        $rate,
        $currentDateTime,
        $_POST['comment']
    ]);

    $output['success'] = !!$stmt->rowCount();
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
