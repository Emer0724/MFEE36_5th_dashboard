<?php
// require './parts/admin-required.php';
require './parts/connection.php';

$output = [
    'success' => false,
    'postData' => $_POST,
    # 除錯用的
    'code' => 0,
    'error' => [],
];
    $isPass = true;

    $sql = "UPDATE `forum_comment` SET 
    `comment`=?
    WHERE `sid`=? ";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['comment'],
            $_POST['sid']
        ]);

        $output['success'] = !!$stmt->rowCount();
    }

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);