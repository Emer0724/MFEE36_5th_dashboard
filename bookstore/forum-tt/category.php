<?php
# MVC
require './parts/connection.php';
$title_1 ='論壇管理';
$title_2 ='類別管理';

$perPage = 5; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$cate_sql = "SELECT COUNT(1) FROM forum_category";
# $t_row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);
# echo json_encode($t_row);
# exit;
$cate_totalRows = $pdo->query($cate_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$cate_totalPages = ceil($cate_totalRows / $perPage);

// echo "$totalRows,  $totalPages";
// exit;

if ($cate_totalRows) {
    if ($page > $cate_totalPages) {
        header("Location: ?page=$cate_totalPages");
        exit;
    }
    $cate_sql = "SELECT * FROM forum_category ORDER BY sid ";

    $cate_rows = $pdo->query($cate_sql)->fetchAll();
}





?>
<?php
$title_1 = '論壇';
$title_2 = '類別管理';

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
                    if ($i >= 1 and $i <= $cate_totalPages) :
                ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                <?php endif;
                endfor; ?>
                <li class="page-item <?= $cate_totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
                <li class="page-item <?= $cate_totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $cate_totalPages ?>">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div> -->
    <div class="container">
        <div class="row">
            <div class="mb-3">
                <h1>類別管理</h1>
            </div>
            <table data-toggle="table" data-sortable="true" data-pagination="true" data-search="true" data-show-search-clear-button="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-show-columns-toggle-all="true">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" data-sortable="true">類別id</th>
                        <th scope="col" class="text-center">類別</th>
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cate_rows as $r) : ?>
                        <tr>
                            <td>
                                <?= $r['sid'] ?>
                            </td>
                            <td>
                                <?= $r['category'] ?>
                            </td>
                            <td><a href="category-edit.php?sid=<?= $r['sid'] ?>">
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
                <a href="category-create.php" class="btn btn-secondary fs-5 d-flex justify-content-center align-items-center" style="width: 150px; height:60px;">新增類別</a>
            </div>
        </div>
    </div>


    <?php include './parts/scripts.php' ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>

    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(sid) {
            if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                location.href = 'category-delete.php?sid=' + sid;
            }

        }
    </script>
    <?php include './parts/html-foot.php' ?>