<?php
require '../parts/connect_db.php';
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
];

$isPass = true;
date_default_timezone_set('Asia/Taipei');
$today = date("Y-m-d H:i:s");
$suggested_price=empty($_POST['$suggested_price']) ? null : $_POST['$suggested_price'];
$sale_price=empty($_POST['$sale_price']) ? null : $_POST['$sale_price'];
$transaction_status=isset($_POST['transaction_status']) ? null :$_POST['transaction_status'];
$visibility=isset($_POST['visibility']) ? null :$_POST['visibility'];

$sql = "UPDATE `used` SET 
`client_id`= ?,
`ISBN`= ?,
`book_status`= ?,
`note`= ?,
`suggested_price`= ?,
`sale_price`= ?,
`transaction_status`= ?,
`visibility`= ?,
`review_status`= ?,
`updated`=?
WHERE `serial_id`= ?";

$stmt = $pdo->prepare($sql);
if ($isPass) {
    $stmt->execute([
        $_POST['client_id'],
        $_POST['ISBN'],
        $_POST['book_status'],
        $_POST['note'],
        $suggested_price,
        $sale_price,
        $transaction_status,
        $visibility,
        $_POST['review_status'],
        $today,
        $_POST['serial_id'],
    ]);
    $output['success'] = !!$stmt->rowCount();
};

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
