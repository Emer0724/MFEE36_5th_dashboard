<?php

require '../parts/admin-required.php';
require '../parts/connect-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if ($sid !== 0) {
    $sql = "DELETE FROM member WHERE sid={$sid}";
    $result = $pdo->query($sql);

    if ($result) {
        header('Location: list-admin.php');
        exit;
    } else {
        echo "<script>
    Swal.fire({
        title: 'ERROR',
        text: '刪除資料失敗',
        icon: 'error',
        showConfirmButton: true
    });
</script>";
    }
}
