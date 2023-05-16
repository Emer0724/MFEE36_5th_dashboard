<?php

require './parts/connection.php';

$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$com_sql = "SELECT COUNT(1) FROM forum_comment";

$com_totalRows = $pdo->query($com_sql)->fetch(PDO::FETCH_NUM)[0]; 
$com_totalPages = ceil($com_totalRows / $perPage);



if ($com_totalRows) {
    if ($page > $com_totalPages) {
        header("Location: ?page=$com_totalPages");
        exit;
    }
    $com_sql = sprintf("SELECT * FROM forum_comment ORDER BY c_sid ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage); 

    $com_rows = $pdo->query($com_sql)->fetchAll();
    
    
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
                    if ($i >= 1 and $i <= $com_totalPages) :
                ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                <?php endif;
                endfor; ?>
                <li class="page-item <?= $com_totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
                <li class="page-item <?= $com_totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $com_totalPages ?>">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php
$join_sql = "SELECT forum_comment.c_sid,forum_comment.comment,forum_comment.created,forum.title,forum.article,forum_comment.parent_id FROM forum_comment LEFT JOIN forum ON forum_comment.parent_id = forum.sid;";

$com_rows1 = $pdo->query($join_sql)->fetchAll();


?>
<div class="container">
    <div class="row">     
            <table class="table table-bordered table-striped">
            <h1>留言管理</h1>
                <thead>
                    <tr>
                        <th scope="col">留言id</th>
                        <th scope="col">留言</th>
                        <th scope="col">標題</th>
                        <th scope="col">文章</th>
                        <th scope="col">建立時間</th>
                        <th scope="col">貼文id</th>
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($com_rows1 as $r) : ?>
                        <tr>
                            <td>
                                <?= $r['c_sid'] ?>
                            </td>
                            <td>
                                <?= $r['comment'] ?>
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
                            <td>
                                <?= $r['parent_id'] ?>
                            </td>
                            <td><a href="comment-edit.php?sid=<?= $r['c_sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td><a href="javascript: delete_it(<?= $r['c_sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <div class="py-5">
           <a href="comment-create.php" class="btn btn-secondary fs-5 d-flex justify-content-center align-items-center" style="width: 150px; height:60px;">新增留言</a>    
        </div>
    </div>
</div>


    <?php include './parts/scripts.php' ?>
    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(c_sid) {
            if (confirm(`是否要刪除編號為 ${c_sid} 的資料?`)) {
                location.href = 'comment-delete.php?c_sid=' + c_sid;
            }

        }
    </script>
    <?php include './parts/html-foot.php' ?>