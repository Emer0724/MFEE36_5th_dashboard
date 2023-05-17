<?php
require './parts/connect-db.php';
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,


];
if (!empty($_POST['email']) and !empty($_POST['password'])) {
    $isPass = true;
    $sql = "SELECT * FROM `admin` WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['email']
    ]);
    $row = $stmt->fetch();
    if (empty($row)) {
        $output['code'] = 410;
    } else {
        if (password_verify($_POST['password'], $row['password'])) {
            $_SESSION['admin'] = $row;
            $output['success'] = true;
        } else {
            $output['code'] = 420;
        }
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
