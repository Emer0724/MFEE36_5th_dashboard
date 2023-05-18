<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => '',
];

if (!empty($_FILES['avatar'])) {
    $filename = sha1($_FILES['avatar']['name'] . uniqid()) . '.jpg';

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], "./imgs/{$filename}")) {
        $output['filename'] = $filename;
    } else {
        $output['error'] = 'cannot move files';
    }
}


if (!empty($_POST['blog_id'])) {
    $isPass = true;

    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "UPDATE `blog` SET 
    `title`=?,
    `img_url`=?,
    `content`=?,
    `time`=?
    WHERE `blog_id`=? ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['title'],
        $output['filename'],
        $_POST['content'],
        $currentDateTime,
        $_POST['blog_id'],
    ]);

    $output['success'] = !!$stmt->rowCount();
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
