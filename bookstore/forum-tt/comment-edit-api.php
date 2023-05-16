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

    $sql = "UPDATE `forum_comment` SET 
    `comment`=?
    WHERE `c_sid`=? ";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['comment'],
            $_POST['c_sid']
        ]);

        $output['success'] = !!$stmt->rowCount();
    }

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);