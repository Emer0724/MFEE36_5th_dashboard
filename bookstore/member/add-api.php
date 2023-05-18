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



if (!empty($_POST['email'])) {
    $isPass = true;


    # TODO: 檢查欄位資料
    $email = trim($_POST['email']); # 去掉頭尾的空白
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (empty($email)) {
        $isPass = false;
        $output['error']['email'] = 'Email 格式不正確';
    }


    $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];


    date_default_timezone_set('Asia/Taipei');
    $today = date("Y-m-d H:i:s");

    $sql = "INSERT INTO `member`(
        `family_name`,`first_name`,`name`,`username`, `gender`,`birthday`, `mobile`,`email`,`full_address`,`id_num`,`password`,`nickname`,`created_at`,`updated`
        ) VALUES (
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?
        )";

    $stmt = $pdo->prepare($sql);
    $full_name = $_POST['family_name'] . $_POST['first_name'];
    $output['name'] = $full_name;


    if ($isPass) {
        $stmt->execute([
            $_POST['family_name'],
            $_POST['first_name'],
            $full_name,
            $_POST['username'],

            $_POST['gender'],
            $birthday,
            $_POST['mobile'],
            $_POST['email'],

            $_POST['full_address'],
            $_POST['id_num'],
            $_POST['password'],
            $_POST['nickname'],

            $today,
            $today,
            // $_POST['mem_avatar'],

        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);