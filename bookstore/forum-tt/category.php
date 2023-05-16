<?php
# MVC
require './parts/connection.php';

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
    $cate_sql = sprintf("SELECT * FROM forum_category ORDER BY sid ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage); //sprintf-格式化字符串 
    // %s -> %表示一個字元s代表字串，常用%s %d; 

    //ex:
    //$name = dick;
    //$person = asshole;
    // $weed = sprintf("my name is %s and i am %s",$name,$person);
    //echo $weed;

    $cate_rows = $pdo->query($cate_sql)->fetchAll();
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
</div>
<div class="container">
    <div class="row">     
            <table class="table table-bordered table-striped">
            <h1>類別管理</h1>
                <thead>
                    <tr>
                        <th scope="col">類別id</th>
                        <th scope="col">類別</th>
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
    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(sid) {
            if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                location.href = 'category-delete.php?sid=' + sid;
            }

        }
    </script>
    <?php include './parts/html-foot.php' ?>