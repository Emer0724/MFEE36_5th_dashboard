<?php

require '../parts/connect-db.php';

// Get the sid and new status from the POST data
$sid = $_POST['sid'];
$status = $_POST['status'];




// Prepare and execute the SQL statement
$sql = "UPDATE member SET `status` = :status, `updated` = :updated WHERE sid = :sid";
$stmt = $pdo->prepare($sql);


// Set the parameter values
date_default_timezone_set('Asia/Taipei');
$updated = date("Y-m-d H:i:s"); //當前時間

$stmt->execute([
    'status' => $status,
    'updated' => $updated,
    'sid' => $sid
]);

$response = ['success' => true];
header('Content-Type: application/json');
echo json_encode($response);
