<?php
require './parts/connect_db.php';
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
];

$sql = "UPDATE `used` SET 
`client_id`=?,
`ISBN`='?,
`book_status`=?,
`note`=?,
`suggested_price`=?,
`sale_price`='?,
`transaction_status`=?,
`visibility`=?,
`review_status`=?,
`updated`=NOW() 
WHERE `serial_id`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['client_id'],
    $_POST['ISBN'],
    $_POST['book_status'],
    $_POST['note'],
    $_POST['suggested_price'],
    $_POST['sale_price'],
    $_POST['transaction_status'],
    $_POST['visibility'],
    $_POST['review_status'],
    $_POST['serial_id'],
]);
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
