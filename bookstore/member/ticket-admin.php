<?php
# MVC
$pageName = 'ticket-admin';
$title = '客服';
require '../parts/connect-db.php';

$perPage = 10; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM ticket";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM ticket ORDER BY ticket_id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}



?>
<style>
    table {
        background-color: white;
        width: 100%;
        border: none;
        background-color: white;
        color: black;
    }

    td {
        white-space: nowrap;
    }

    .td-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        max-width: 0;
    }


    th {
        border: none;
        background-color: white;
        color: black;
    }
</style>

<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>


<!-- d-flex align-items-center justify-content-center -->
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
        </nav>
    </div>
    <div class="row d-flex align-items-center justify-content-center card mx-1">
        <table class="table table-bordered table-striped table-sm col-7 mx-1">
            <thead>
                <tr>
                    <th scope="col" class='text-center'><i class="fa-solid fa-trash-can"></i></th>
                    <th scope="col" class='text-center'>#</th>
                    <th scope="col" class='text-center'>類別</th>
                    <th scope="col" class='text-center'>會員id</th>
                    <th scope="col">敘述內容</th>
                    <th scope="col" class='text-center'>提出時間</th>
                    <th scope="col">回覆內容</th>
                    <th scope="col"><i class="fa-solid fa-reply"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <td class='text-center'><a href="javascript: delete_it(<?= $r['ticket_id'] ?>)">
                                <i class="fa-solid fa-trash-can"></i>
                            </a></td>
                        <td class='text-center'><?= $r['ticket_id'] ?></td>
                        <td class='text-center'><?= $r['category'] ?></td>
                        <td class='text-center'><?= $r['member_id'] ?></td>
                        <td class="td-truncate"><?= $r['description'] ?></td>
                        <td><?= $r['created'] ?></td>
                        <td class="td-truncate"><?= $r['reply'] ?></td>
                        <td class='text-center'><a href="reply.php?ticket_id=<?= $r['ticket_id'] ?>">
                                <i class="fa-solid fa-reply"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include '../parts/scripts.php' ?>

<script>
    document.querySelector('li.page-item.active a').removeAttribute('href');

    function delete_it(ticket_id) {
        if (confirm(`是否要刪除編號為 ${ticket_id} 的資料?`)) {
            location.href = 'delete.php?ticket_id=' + ticket_id;
        }

    }
</script>
<?php include '../parts/html-foot.php' ?>