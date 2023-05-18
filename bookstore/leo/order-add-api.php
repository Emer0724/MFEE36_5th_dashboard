<?php

require '../parts/admin-required.php';
require '../parts/connect-db.php';

$output = [
  'success' => false,
  'postData' => $_POST, # 除錯用的
  'code' => 0,
  'error' => [],
];



if (!empty($_POST['order_id'])) {
  $isPass = true;


  // # TODO: 檢查欄位資料
  // $email = trim($_POST['email']); # 去掉頭尾的空白
  // $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  // if (empty($email)) {
  //   $isPass = false;
  //   $output['error']['email'] = 'Email 格式不正確';
  // }


  // $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];


  $sql_1 = "INSERT INTO `orders`(
       `client_id`, `created`,
        `updated`, `price`
        ) VALUES (
            ?, ?,
            ?, ?
        )";
  $sql_2 = "SELECT * FROM orders ORDER BY id DESC LIMIT 1 ";

  $stmt = $pdo->query($sql_2);

  $sql_3 = "INSERT INTO `order_details`(
  `order_id`,`ISBN`, `created`,
   `updated`, `status`,`qty`
   ) VALUES 
   <?php foreach() ?>
   (
       ?,?,?, 
       ?,?,?
   )";

  $stmt = $pdo->prepare($sql);

  if ($isPass) {
    $stmt->execute([
      $_POST['order_id'],
      $_POST['client_id'],
      $_POST['created'],
      $_POST['updated'],
      $_POST['status'],
      $_POST['price'],
    ]);

    $output['success'] = !!$stmt->rowCount();
  }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
