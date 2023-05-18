<?php

require './parts/admin-required.php';
require './parts/connect-db.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
];



if (!empty($_POST['name'])) {
    $isPass = true;


    $sql = "INSERT INTO `member`(
        `name`, `email`, `mobile`,
        `birthday`, `address`, `created_at`
        ) VALUES (
            ?, ?, ?,
            ?, ?, NOW()
        )";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['mobile'],
            $birthday,
            $_POST['address'],
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
