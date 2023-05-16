<?php

require './parts/connection.php';

$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM forum";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; 
$totalPages = ceil($totalRows / $perPage);


$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM forum ORDER BY sid ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}


?>
<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>


<?php include('./parts/navbar.php') ?>



<div class="container ">
    <div class="row">
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
                <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
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
        </nav>
    </div>
</div>
<div class="container">
    <div class="row"> 
        <h1>貼文管理</h1>    
            <table class="table table-bordered table-striped " style="padding-right: 300px;">
                <thead>
                    <tr>
                        <th scope="col">貼文id</th>
                        <th scope="col">會員暱稱</th>
                        <th scope="col">類別</th>
                        <th scope="col">標題</th>
                        <th scope="col">內容</th>
                        <th scope="col">建立時間</th>
                        <th scope="col">編輯</i></th>
                        <th scope="col">刪除</i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <?= $r['sid'] ?>
                            </td>
                            <td>
                                <?= $r['member-name'] ?>
                            </td>
                            <td>
                                <?= $r['category'] ?>
                            </td>
                            <td>
                                <?= $r['title'] ?>
                            </td>
                            <td>
                                <?= $r['article'] ?>
                            </td>
                            <td>
                                <?= $r['created'] ?>
                            </td>
                            <td><a href="post-edit.php?sid=<?= $r['sid'] ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td><a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                <i class="fa-solid fa-trash-can"></i>
                            </a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="py-5">
               <a href="./post-create.php" class="btn btn-secondary fs-5 d-flex justify-content-center align-items-center " style="width: 150px; height:60px;">新增公告</a>
            </div>
            
    </div>
</div>


    <?php include './parts/scripts.php' ?>
    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(sid) {
            if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                location.href = 'post-delete.php?sid=' + sid;
            }

        }
    </script>
    <?php include './parts/html-foot.php' ?>