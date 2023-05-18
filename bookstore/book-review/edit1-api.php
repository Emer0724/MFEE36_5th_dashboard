<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rate = $_POST['rate'];
}

if (!empty($_POST['sid'])) {
    $isPass = true;

    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "UPDATE `book_comment` SET 
    `comment`=?,
    `created`=?,
    `rate`=?
    WHERE `sid`=? ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['comment'],
        $currentDateTime,
        $rate,
        $_POST['sid'],
    ]);

    $output['success'] = !!$stmt->rowCount();
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
