<?php
require '../parts/connect_db.php';
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,


];
if (!empty($_POST['email']) and !empty($_POST['password'])) {
    $isPass = true;
    $sql = "SELECT * FROM `member` WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['email']
    ]);
    $row = $stmt->fetch();
    if (empty($row)) {
        $output['code'] = 410;
    } else {
        if ($_POST['password']== $row['password']) {
            $_SESSION['sid'] = $row;
            $output['success'] = true;
        } else {
            $output['code'] = 420;
        }
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
