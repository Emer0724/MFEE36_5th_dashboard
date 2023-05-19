<?php
require '../parts/connect_db.php';
//require '../parts/admin-required.php';
$serial_id = isset($_GET['serial_id']) ? intval($_GET['serial_id']) : 0;
$sql = "UPDATE `used` SET 
`updated`=?,
`deleted`=?
WHERE `serial_id`=?";
$stmt = $pdo->prepare($sql);
$deleted = 'Y';
date_default_timezone_set('Asia/Taipei');
$today = date("Y-m-d H:i:s");
$stmt->execute([
    $today,
    $deleted,
    $serial_id,
]);
$comeFrom = "used_list_1.php";
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
};
header('Location: ' . $comeFrom);
