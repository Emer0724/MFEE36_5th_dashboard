<?php
require '../parts/connect_db.php';
$output = [

    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],


];

if (isset($_POST['status_id']) && isset($_POST['status_name']) && isset($_POST['status_rule']) && isset($_POST['discount'])) {

    $status_id = $_POST['status_id'];

    $isPass = true;

    if ($isPass) {
        $sql = "UPDATE `book_status` SET `status_name`=?,`status_rule`=?,`discount`=? WHERE `status_id`=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['status_name'],
            $_POST['status_rule'],
            $_POST['discount'],
            $status_id
        ]);
        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');

echo json_encode($output, JSON_UNESCAPED_UNICODE);
