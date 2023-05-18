<?php
// require '../parts/admin-required.php';
require '../parts/connect-db.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
];



if (!empty($_POST['email']) and !empty($_POST['sid'])) {
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


    $sql = "UPDATE `member` SET 
    `family_name`=?,`first_name`=?,`name`=?,`username`=?, 
    `gender`=?,`birthday`=?, `mobile`=?,`email`=?,
    `full_address`=?,`id_num`=?,`password`=?,`nickname`=?,
    `updated`=?
    
   

    WHERE `sid`=? ";

    $stmt = $pdo->prepare($sql);
    $full_name = $_POST['family_name'] . $_POST['first_name'];



    if ($isPass) {
        // 檢查 $_POST 陣列是否包含 "gender" 索引
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $stmt->execute([
            $_POST['family_name'],
            $_POST['first_name'],
            $full_name,
            $_POST['username'],

            $gender, // 使用檢查後的 $gender 變數
            $birthday,
            $_POST['mobile'],
            $_POST['email'],

            $_POST['full_address'],
            $_POST['id_num'],
            $_POST['password'],
            $_POST['nickname'],


            $today,
            $_POST['sid']
            // $_POST['mem_avatar'],
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
