<?php
$pageName = 'book-comment';
$title_1 = '書評';
$title_2 = '書評管理';
require '../parts/db-connect.php';
require './admin-re1.php';
$perPage = 10; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$sql1 = "SELECT * FROM book_comment  JOIN member  ON book_comment.sid = member.sid";
$stmt = $pdo->query($sql1)->fetch(PDO::FETCH_NUM)[0];
$stmtt = ceil($stmt / $perPage);


$t_sql = "SELECT COUNT(1) FROM book_comment";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }


    $sql =  sprintf("SELECT a.*,b.name as book_name,b.img_url,c.nickname,c.sid as m_sid  FROM book_comment as a left JOIN book_info as b using(ISBN) left join member as c on  a.sid = c.sid  ORDER BY a.ISBN ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);


    // $sql = sprintf("SELECT 
    // member.sid,
    // member.nickname,
    // comment,
    // created,
    // rate 
    // FROM book_comment JOIN member ON book_comment.sid = member.sid ORDER BY book_comment.sid ASC LIMIT %s, %s ", ($page - 1) * $perPage, $perPage);


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
            <th scope="col" data-field="sid" data-sortable="true">sid</th>
            <th scope="col">暱稱</th>
            <th scope="col">書名</th>
            <th scope="col">圖片</th>
            <th scope="col" data-field="rate" data-sortable="true">評分</th>
            <th scope="col" data-field="created" data-sortable="true">時間</th>
            <th scope="col">評論</th>
            <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <td class="c_td"><a href="javascript: delete_it(<?= $r['sid'] ?>)"><i class="fa-solid fa-trash-can link-secondary"></i></a></td>
                <td style="text-align: center;"><?= $r['m_sid'] ?></td>
                <td style="text-align: center;"><?= $r['nickname'] ?></td>
                <td style="text-align: center;"><?= $r['book_name'] ?></td>
                <td><img src="<?= $r['img_url'] ?>" alt="書圖"></td>
                <td><?= $r['rate'] ?></td>
                <td><?= $r['created'] ?></td>
                <td><?= $r['comment'] ?></td>
                <td style="text-align: center;"><a href="edit1.php?sid=<?= $r['sid'] ?>"><i class="fa-solid fa-pen-to-square link-secondary"></i></a></td>
            </tr>
        <?php endforeach ?>

    </tbody>
</table>
<?php include '../parts/scripts.php' ?>
<script>
    document.querySelector('li.page-item.active a').removeAttribute('href');

    function delete_it(sid) {
        if (confirm(`是否要刪除編號 ${sid} 的資料?`)) {
            location.href = 'delete1.php?sid=' + sid;
        }
    }

    function add() {
        window.location.href = "add1.php";
    }
</script>
<?php include '../parts/html-foot.php' ?>