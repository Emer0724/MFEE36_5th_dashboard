<?php

require './parts/connection.php';
$title_1 = '論壇管理';
$title_2 = '留言管理';

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
<?php
$title_1 = '論壇';
$title_2 = '留言管理';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>
        book書易後台管理系統
    </title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <!-- b-table-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">

    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>


</head>

<body class="g-sidenav-show bg-gray-200">

    <?php include('./parts/aside.php') ?>


    <?php include('./parts/navbar.php') ?>


    <!-- <div class="container">
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
</div> -->

    <?php
    $join_sql = "SELECT forum_comment.c_sid,forum_comment.comment,forum_comment.created,forum.title,forum.article,forum_comment.parent_id FROM forum_comment LEFT JOIN forum ON forum_comment.parent_id = forum.sid;";

    $com_rows1 = $pdo->query($join_sql)->fetchAll();


    ?>
    <!--substring(forum.article,1,10) as s_article-->

    <div class="container">
        <div class="mb-3">
            <h1>留言管理</h1>
        </div>
        <table data-toggle="table" data-sortable="true" data-pagination="true" data-search="true" data-show-search-clear-button="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-show-columns-toggle-all="true">
            <thead>
                <tr>
                    <th scope="col" class="text-center" data-sortable="true">留言id</th>
                    <th scope="col" class="text-center">留言</th>
                    <th scope="col" class="text-center">標題</th>
                    <th scope="col" class="text-center">內容</th>
                    <th scope="col" class="text-center" data-sortable="true">建立時間</th>
                    <th scope="col" class="text-center" data-sortable="true">貼文id</th>
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
        <!-- <div class="py-5">
           <a href="comment-create.php" class="btn btn-secondary fs-5 d-flex justify-content-center align-items-center" style="width: 150px; height:60px;">新增留言</a>    
    </div> -->

    </div>


    <?php include './parts/scripts.php' ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>

    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(c_sid) {
            if (confirm(`是否要刪除編號為 ${c_sid} 的資料?`)) {
                location.href = 'comment-delete.php?c_sid=' + c_sid;
            }

        }
    </script>
    <?php include './parts/html-foot.php' ?>