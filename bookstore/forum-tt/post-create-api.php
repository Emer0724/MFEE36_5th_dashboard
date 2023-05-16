<?php
// require './parts/admin-required.php';
require './parts/connection.php';

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];
$isPass = true;

$sql = "INSERT INTO `forum`(
    `member-name`,`category`,`title`,`article`,`created`
    ) VALUES (
        '管理員','公告',?, ?, NOW()
    )";

$stmt = $pdo->prepare($sql);
if($isPass){
    $stmt->execute([
        $_POST['title'],
        $_POST['article']
    ]);

    $output['success'] = !! $stmt->rowCount();
};
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);