<?php
# MVC
$pageName = 'list';
$title_1 = '會員管理';
$title_2 = '會員清單';
require '../parts/connect-db.php';
// require '../user_img.php';


$perPage = 10; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM member";
// $t_sql = "SELECT COUNT(1) FROM member JOIN";
// $t_sql = "SELECT a.*, b.sub_total from member as a left join (select client_id, sum(price)as sub_total from orders GROUP by client_id) as b on a.sid=b.client_id";


$sqlStatusEmpty = sprintf("SELECT * FROM member WHERE (status = '' OR status IS NULL) AND sid IS NOT NULL ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$rowsStatusEmpty = $pdo->query($sqlStatusEmpty)->fetchAll();

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM member ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}

function stringToHslColor($str, $s, $l)
{
    $hash = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $hash = ord($str[$i]) + (($hash << 5) - $hash);
    }

    $h = $hash % 360;
    return 'hsl(' . $h . ', ' . $s . '%, ' . $l . '%)';
}



//<---------------------------------->

// Query for all members where id is not NULL
// $account_disabled = sprintf("SELECT * FROM member WHERE status = '' AND sid IS NOT NULL ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
// $rowsAll = $pdo->query($sqlAll)->fetchAll();

// Query for members with empty status where id is not NULL
// $sqlStatusEmpty = sprintf("SELECT * FROM member WHERE (status = '' OR status IS NULL) AND sid IS NOT NULL ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

// $rowsStatusEmpty = $pdo->query($sqlStatusEmpty)->fetchAll();

// $t_sqlAll = "SELECT COUNT(1) FROM member WHERE sid IS NOT NULL";
// $t_sqlStatusEmpty = "SELECT COUNT(1) FROM member WHERE status = '' AND sid IS NOT NULL";

//<---------------------------------->


?>

<style>
    .user-image {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1em;
        color: white;
    }

    table,
    th {
        border: none;
        background-color: white;
        color: black;
    }

    table tr:hover {
        background-color: #AFDDD5;
    }

    .modal {
        z-index: 999;
    }

    #modal-control {
        position: relative;
        right: 0;
        top: 0;
        /* z-index: 9999; */

    }
</style>


<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>



<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between">
            <div class="nav-container">
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

            <div class="add">
                <a href="add.php" class="btn btn-primary">新增</a>
            </div>
            <button type="button" class="btn btn-dark" id="modal-control" data-bs-toggle="modal" data-bs-target="#exampleModal">停權帳號</button>

        </div>
    </div>
</div>
<div class="row mx-1 card">
    <table class="table table-bordered rounded">
        <thead>
            <tr>
                <th scope="col" class='text-center'>會員狀態</th>
                <th scope="col" class='text-center'>大頭照</th>
                <th scope="col" class='text-center'>#</th>
                <th scope="col" class='text-center'>姓名</th>
                <th scope="col" class='text-center'>手機</th>
                <th scope="col" class='text-center'>email</th>
                <th scope="col" class='text-center'>暱稱</th>
                <th scope="col" class='text-center text-truncate'>地址</th>
                <th scope="col" class='text-center'>編輯</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td class="d-flex align-items-center justify-content-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" id="flexSwitchCheckChecked" data-sid="<?= $r['sid'] ?>" <?= $r['status'] == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                        </div>
                    </td>
                    <td class='text-center'>
                        <div class="profile-image d-flex align-items-center justify-content-center">
                            <?php
                            $initial = mb_substr($r['email'], 0, 1, "UTF-8");
                            $initial = strtoupper($initial);
                            $color = stringToHslColor($initial, 50, 50);
                            ?>
                            <div class='user-image' style='background-color: <?= $color ?>;'><?= $initial ?></div>
                        </div>
                    </td>
                    <td class='text-center'><?= $r['sid'] ?></td>
                    <td class='text-center'><?= $r['name'] ?></td>
                    <td class='text-center'><?= $r['mobile'] ?></td>
                    <td class='text-center'><?= $r['email'] ?></td>
                    <td class='text-center'><?= $r['nickname'] ?></td>
                    <td class='text-center'><?= $r['full_address'] ?? '' ?></td>
                    <td class="d-flex align-items-center justify-content-center">
                        <a href="edit.php?sid=<?= $r['sid'] ?>">
                            <i class="fa-solid fa-pen-to-square text-center"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Modal -->


<div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">停權帳號</h5>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form> -->



                <table class="table" id="table" data-toggle="table" data-search="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-pagination-switch="true" data-pagination="true" data-toolbar="form" data-resizable="true" data-id-field="id" data-click-to-select="true">

                    <thead>
                        <tr>

                            <th scope="col" class='text-center' data-sortable='true'>會員狀態</th>
                            <th scope="col" class='text-center' data-sortable='true'>大頭照</th>
                            <th scope="col" class='text-center' data-sortable='true'>#</th>
                            <th scope="col" class='text-center' data-sortable='true'>姓名</th>
                            <th scope="col" class='text-center' data-sortable='true'>手機</th>
                            <th scope="col" class='text-center' data-sortable='true'>email</th>
                            <th scope="col" class='text-center' data-sortable='true'>暱稱</th>
                            <th scope="col" class='text-center' data-sortable='true'>消費金額</th>
                            <th scope="col" class='text-center' data-sortable='true'>編輯</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($rowsStatusEmpty as $r) : ?>
                            <tr>
                                <td class="d-flex align-items-center justify-content-center form-check form-switch">
                                    <!-- <div class="form-check form-switch"> -->
                                    <input class="form-check-input status-toggle" style="border:none" type="checkbox" id="flexSwitchCheckChecked" data-sid="<?= $r['sid'] ?>" <?= $r['status'] == 'Y' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    <!-- </div> -->
                                </td>
                                <td class='text-center'>
                                    <div class="profile-image">
                                        <?php
                                        $initial = mb_substr($r['email'], 0, 1, "UTF-8");
                                        $initial = strtoupper($initial);
                                        $color = stringToHslColor($initial, 50, 50);
                                        ?>
                                        <div class='user-image' style='background-color: <?= $color ?>;'><?= $initial ?></div>
                                    </div>
                                </td>
                                <td class='text-center'><?= $r['sid'] ?></td>
                                <td class='text-center'><?= $r['name'] ?></td>
                                <td class='text-center'><?= $r['mobile'] ?></td>
                                <td class='text-center'><?= $r['email'] ?></td>
                                <td class='text-center'><?= $r['nickname'] ?></td>
                                <td class='text-center'><?= $r['sub_total'] ?? '' ?></td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="edit.php?sid=<?= $r['sid'] ?>">
                                        <i class="fa-solid fa-pen-to-square text-center"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>


                </table>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>

<script src="./js/bootstrap.bundle.min.js"></script>
<script>
    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = exampleModal.querySelector('.modal-title')
        var modalBodyInput = exampleModal.querySelector('.modal-body input')

        modalTitle.textContent = 'New message to ' + recipient
        modalBodyInput.value = recipient
    })
</script>


<?php include '../parts/scripts.php' ?>
<script src="https://code.jquery.com/jquery-3.6.4.js"></script>

<script>
    document.querySelector('li.page-item.active a').removeAttribute('href');

    function delete_it(<?= $r['sid'] ?>) {
        Swal.fire({
            title: '確定要刪除會員的全部資料嗎?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_it(sid);
                delete_it
            }
        });

    }
</script>

<!-- Modal -->

<script>
    const statusToggle = document.querySelector('.status-toggle');

    statusToggle.addEventListener('change', function() {
        const sid = this.dataset.sid;
        const status = this.checked ? 'Y' : null;

        // 发送 AJAX 请求
        fetch('update-status.php', {
                method: 'POST',
                body: JSON.stringify({
                    sid: sid,
                    status: status
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 更新成功
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })

                } else {
                    // 更新失敗
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        // footer: '<a href="">Why do I have this issue?</a>'
                        position: 'center',

                    })
                }
            })
            .catch(error => {
                console.error(error);
            });
    });

    // 
</script>

<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var sid = $(this).data('sid');
            var status = $(this).is(':checked') ? 'Y' : 'N';

            $.ajax({
                url: 'update_status.php',
                method: 'POST',
                data: {
                    sid: sid,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            // footer: '<a href="">Why do I have this issue?</a>',
                            position: 'center',

                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        // footer: '<a href="">Why do I have this issue?</a>',
                        position: 'center',

                    });
                }
            });
        });
    });
</script>


<script>
    // change class on each of the panel

    // use querySelectorAll to select all panels
    // NodeList
    const panels = document.querySelectorAll('.panel')

    // panel action: remove unused panel then active selected one
    panels.forEach((panel) => {
        panel.addEventListener('click', () => {

            removeActiveClasses()
            panel.classList.add('active')
        })
    })

    // define a function to remove active status
    function removeActiveClasses() {
        panels.forEach(panel => {
            panel.classList.remove('active')
        })
    }
</script>




<?php include '../parts/html-foot.php' ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/locale/zh_TW.js"></script>

<?php include '../parts/html-foot.php' ?>