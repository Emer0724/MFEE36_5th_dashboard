<?php
// require './parts/admin-required.php';
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
];

date_default_timezone_set('Asia/Taipei');
$today = date("Y-m-d H:i:s");


if (!empty($_POST['ISBN'])) {
    $isPass = true;


    // # TODO: 檢查欄位資料
    // $email = trim($_POST['email']); # 去掉頭尾的空白
    // $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    // if (empty($email)) {
    //     $isPass = false;
    //     $output['error']['email'] = 'Email 格式不正確';
    // }


    // $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];


    $sql = "UPDATE `book_info` SET 
    `ISBN`=?,
    `name`=?,
    `img_url`=?,
    `author`=?,
    `publisher`=?,
    `list_price`=?,
    `retail_price`=?
       
    WHERE `ISBN`=? ";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['ISBN'],
            $_POST['name'],
            $_POST['img_url'],
            $_POST['author'],
            $_POST['publisher'],
            $_POST['list_price'],
            $_POST['retail_price'],
            $_POST['ISBN']
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
