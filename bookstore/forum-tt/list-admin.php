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
    $sql = sprintf("SELECT * FROM forum ORDER BY sid ASC   LIMIT %s, %s", ($page - 1) * $perPage, $perPage); 
    $rows = $pdo->query($sql)->fetchAll();
}

?>
<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>


<?php include('./parts/navbar.php') ?>


<div class="container">
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
    <div class="container">
        <div class="row">     
        <table class="table table-bordered table-striped">
            <h1>CATEGORY</h1>
                <thead>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                        <th scope="col">sid</th>
                        <th scope="col">category</th>
                        <th scope="col">created</th>
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a></td>
                            <td>
                                <?= $r['sid'] ?>
                            </td>
                            <td>
                                <?= $r['category'] ?>
                            </td>
                            <td>
                                <?= $r['created'] ?>
                            </td>
                            <td><a href="edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="table table-bordered table-striped">
            <h1>POST</h1>
                <thead>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                        <th scope="col">sid</th>
                        <th scope="col">author</th>
                        <th scope="col">category</th>
                        <th scope="col">title</th>
                        <th scope="col">article</th>
                        <th scope="col">created</th>
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a></td>
                            <td>
                                <?= $r['sid'] ?>
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
                            <td><a href="edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="table table-bordered table-striped">
            <h1>COMMENT</h1>
                <thead>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                        <th scope="col">sid</th>
                        <th scope="col">comment</th>
                        <th scope="col">created</th>
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a></td>
                            <td>
                                <?= $r['sid'] ?>
                            </td>
                            <td>
                                <?= $r['comment'] ?>
                            </td>
                            <td>
                                <?= $r['created'] ?>
                            </td>
                            <td><a href="comment.edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php include './parts/scripts.php' ?>
    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(sid) {
            if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                location.href = 'delete.php?sid=' + sid;
            }

        }
    </script>
    <?php include './parts/html-foot.php' ?>