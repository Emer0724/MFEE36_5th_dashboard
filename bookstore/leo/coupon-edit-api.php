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


if (!empty($_POST['name'])) {
    $isPass = true;


    // # TODO: 檢查欄位資料
    // $email = trim($_POST['email']); # 去掉頭尾的空白
    // $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    // if (empty($email)) {
    //     $isPass = false;
    //     $output['error']['email'] = 'Email 格式不正確';
    // }


    // $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];


    $sql = "UPDATE `coupon` SET 
    `name`=?,
    `amount`=?,
    `start`=?,
    `end`=?,
    `period`=null    
    WHERE `name`=? ";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['name'],
            $_POST['amount'],
            $_POST['start'],
            $_POST['end'],
            $_POST['name'],
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
$comeFrom = 'market.php';
// if (!empty($_SERVER['HTTP_REFERER'])) {
//     $comeFrom = $_SERVER['HTTP_REFERER'];
// }

// header('Location: ' . $comeFrom);
