<?php
# MVC
$pageName = 'list';
$title = '列表';
require './parts/connect-db.php';

$perPage = 25; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM address_book";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM address_book LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}



?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>



<div class="container">
</div>
<?php include './parts/scripts.php' ?>
<script>
    let data = <?= json_encode([
                    'perPage' => $perPage,
                    'page' => $page,
                    'totalRows' => $totalRows,
                    'totalPages' => $totalPages,
                    'rows' => $rows,
                ], JSON_UNESCAPED_UNICODE) ?>;
</script>
<?php include './parts/html-foot.php' ?>