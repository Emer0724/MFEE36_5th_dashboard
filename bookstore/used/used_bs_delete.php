<?php
require '../parts/connect_db.php';
//require '../parts/admin-required.php';
$serial_id = isset($_GET['status_id']) ? $_GET['status_id'] : 0;
$sql = "UPDATE `book_status` SET 

`deleted`=?
WHERE `status_id`=?";
$stmt = $pdo->prepare($sql);
$deleted = 'Y';

$stmt->execute([

    $deleted,
    $serial_id,
]);
$comeFrom = "used_bs_list.php";
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
};
header('Location: ' . $comeFrom);
