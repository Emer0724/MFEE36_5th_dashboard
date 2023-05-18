<?php
require '../parts/connect-db.php';

$isPass = true;

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => '',
];

$currentDateTime = date('Y-m-d H:i:s');

if (!empty($_FILES['avatar'])) {
    $filename = sha1($_FILES['avatar']['name'] . uniqid()) . '.jpg';

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], "./imgs/{$filename}")) {
        $output['filename'] = $filename;
    } else {
        $output['error'] = 'cannot move files';
    }
}

if ($isPass) {
    $sql = "INSERT INTO `blog` (`client_id`,`title`, `img_url`, `content`, `time`) VALUES (? ,?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['sid'],
        $_POST['title'],
        $filename,
        $_POST['content'],
        $currentDateTime
    ]);

    $output['success'] = !!$stmt->rowCount();
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
