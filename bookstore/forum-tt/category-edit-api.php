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

    $sql = "UPDATE `forum_category` SET 
    `category`=?
    WHERE `sid`=?";

    $stmt = $pdo->prepare($sql);

   
        $stmt->execute([
            $_POST['category'],
            $_POST['sid']
        ]);

        $output['success'] = !!$stmt->rowCount();
        

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);