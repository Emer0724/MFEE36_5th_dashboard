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

$sql = "INSERT INTO `forum_category`(
    `category`
    ) VALUES (
        ?
    )";

$stmt = $pdo->prepare($sql);
if($isPass){
    $stmt->execute([
        $_POST['category']
    ]);

    $output['success'] = !! $stmt->rowCount();
};
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);