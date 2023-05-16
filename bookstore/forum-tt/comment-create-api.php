<?php
// require './parts/admin-required.php';
require './parts/connection.php';

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
];




    $isPass = true;


    $sql = "INSERT INTO `forum_comment`(
        `comment`,`created`
        ) VALUES (
        ?, NOW()
        )";

    $stmt = $pdo->prepare($sql);

    
        $stmt->execute([
            $_POST['comment']
        ]);
    
        $output['success'] = !! $stmt->rowCount();
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);