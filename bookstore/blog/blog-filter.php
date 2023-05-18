<?php
$pageName = 'blog';
$titla_1 = '部落格';
$titla_2 = '部落格管理';
require '../parts/db-connect.php';
require './admin-re.php';
$perPage = 10; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$sql1 = "SELECT * FROM blog  JOIN member  ON client_id = member.sid";
$stmt = $pdo->query($sql1)->fetch(PDO::FETCH_NUM)[0];
$stmtt = ceil($stmt / $perPage);


$t_sql = "SELECT COUNT(1) FROM blog";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM blog  JOIN member  ON client_id = member.sid ORDER BY blog_id ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}

?>
<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1">
                <i class="fa-solid fa-angles-left"></i>
            </a>
        </li>
        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>
        <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) :
        ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
        <?php endif;
        endfor; ?>
        <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </li>
        <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?>">
                <i class="fa-solid fa-angles-right"></i>
            </a>
        </li>
    </ul>
    <div class="d-grid gap-2 d-md-block">
        <button class="btn btn-primary" onclick="add()" type="button">上傳</button>
    </div>
</nav>

</div>
<table class="table table-dark table-striped" data-toggle="table" data-sort-class="table-active" data-search="ture" data-show-search-clear-button="ture" data-show-columns="ture">
    <thead>
        <tr>
            <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
            <th scope="col" data-field="blog_id" data-sortable="true">sid</th>
            <th scope="col" data-field="nickname">使用者</th>
            <th scope="col" data-field="title">標題</th>
            <th scope="col" data-field="img_url">圖片</th>
            <th scope="col" data-field="content">文章</th>
            <th scope="col" data-field="time" data-sortable="true">時間</th>
            <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <td style="text-align: center;"><a href="javascript: delete_it(<?= $r['blog_id'] ?>)"><i class="fa-solid fa-trash-can link-secondary"></i></a></td>
                <td style="text-align: center;"><?= $r['blog_id'] ?></td>
                <td style="text-align: center;"><?= $r['nickname'] ?></td>
                <td style="text-align: center;"><?= $r['title'] ?></td>
                <td><img style="height: 70px;width: 70px;" src="./imgs/<?= $r['img_url'] ?>" alt=""></td>
                <td><?= $r['content'] ?></td>
                <td><?= $r['time'] ?></td>
                <td style="text-align: center;"><a href="edit.php?blog_id=<?= $r['blog_id'] ?>"><i class="fa-solid fa-pen-to-square link-secondary"></i></a></td>
            </tr>
        <?php endforeach ?>

    </tbody>
</table>
<?php include '../parts/scripts.php' ?>
<script>
    document.querySelector('li.page-item.active a').removeAttribute('href');

    function delete_it(sid) {
        if (confirm(`是否要刪除編號 ${sid} 的資料?`)) {
            location.href = 'delete.php?blog_id=' + sid;
        }
    }

    function add() {
        window.location.href = "add.php";
    }
</script>
<?php include '../parts/html-foot.php' ?>