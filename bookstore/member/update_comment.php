<?php
require '../parts/connect-db.php';

// 獲取從表單提交的值
$ticket_id = $_POST['ticket_id'];
$comment = $_POST['comment'];


date_default_timezone_set('Asia/Taipei');
$today = date("Y-m-d H:i:s");


// 更新資料庫中的"updated"欄位
try {
    $stmt = $pdo->prepare("UPDATE ticket SET updated = CURRENT_TIMESTAMP, comment = :comment WHERE ticket_id = :ticket_id");
    $stmt->bindParam(':ticket_id', $ticket_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
} catch (PDOException $e) {
    die("更新失敗：" . $e->getMessage());
}

// 關閉資料庫連線
$pdo = null;

// 重定向回"reply.php"頁面
header("Location: reply.php?ticket_id=$ticket_id");
exit();
