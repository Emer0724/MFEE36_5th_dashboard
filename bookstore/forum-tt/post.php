<?php
# MVC
require './parts/connection.php';

$perPage = 5; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM forum";
# $t_row = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM);
# echo json_encode($t_row);
# exit;
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage);

// echo "$totalRows,  $totalPages";
// exit;
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM forum ORDER BY sid ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage); //sprintf-格式化字符串 
    // %s -> %表示一個字元s代表字串，常用%s %d; 

    //ex:
    //$name = dick;
    //$person = asshole;
    // $weed = sprintf("my name is %s and i am %s",$name,$person);
    //echo $weed;

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
            <h1>貼文管理</h1>
                <thead>
                    <tr>
                        <th scope="col">貼文id</th>
                        <th scope="col">會員暱稱</th>
                        <th scope="col">類別</th>
                        <th scope="col">標題</th>
                        <th scope="col">內容</th>
                        <!-- <th scope="col">author</th> -->
                        <th scope="col">建立時間</th>
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
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
            <div class="">
                <a class="nav-link <?= $pageName == 'add' ? 'active' : '' ?>" href="post-create.php">新增公告</a>
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