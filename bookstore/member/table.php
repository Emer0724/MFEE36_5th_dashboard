<?php
# MVC
$pageName = 'list';
$title1 = '會員管理';
$title2 = '會員資料清單';
require '../parts/connect-db.php';
// require '../user_img.php';


$perPage = 10; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

// $t_sql = "SELECT COUNT(1) FROM member JOIN";
$t_sql = "SELECT a.*, b.sub_total from member as a left join (select client_id, sum(price)as sub_total from orders GROUP by client_id) as b on a.sid=b.client_id";


$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = "SELECT * FROM member ORDER BY sid DESC";
    // $sql = sprintf("SELECT * FROM member ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

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


?>

<link href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">

<!-- <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/export/bootstrap-table-export.min.js"></script> -->



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

    .select,
    #locale {
        width: 100%;
    }

    .like {
        margin-right: 10px;
    }

    table,
    th {
        /* border: none; */
        background-color: white;
        color: black;
    }

    table tr:hover {
        background-color: #AFDDD5;
    }
</style>




<div class="container">

    <!-- <div class="bootstrap-table bootstrap5">
            <div class="fixed-table-toolbar"></div>
            <div class="fixed-table-container"></div>
            <div class="fixed-table-pagination"></div>
        </div> -->
    <!-- <table class="table order-table" data-toggle="table" data-search="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-pagination-switch="true" data-pagination="true" data-toolbar="form" data-resizable="true" data-id-field="id" id="table"> -->
    <div class="select">
        <select class="form-control" id="locale">
            <option value="en-US">en-US</option>
            <option value="zh-TW" selected>zh-TW</option>
        </select>
    </div>
    <div id="toolbar">
        <button id="remove" class="btn btn-danger" disabled>
            <i class="fa fa-trash"></i> Delete
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Search">
    </div> -->
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
            <?php foreach ($rows as $r) : ?>
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


<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>


<!-------------------------------------------------  -->


<?php
// include '../parts/scripts.php' 
?>

<!-- <script src="https://code.jquery.com/jquery-3.6.4.js"></script> -->

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
            }
        });

    }


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

    var $table = $('#table')
    var $remove = $('#remove')
    var selections = []

    $(function() {
        $('#table').bootstrapTable()
    })

    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function(row) {
            return row.id
        })
    }

    function responseHandler(res) {
        $.each(res.rows, function(i, row) {
            row.state = $.inArray(row.id, selections) !== -1
        })
        return res
    }

    function detailFormatter(index, row) {
        var html = []
        $.each(row, function(key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        })
        return html.join('')
    }

    function operateFormatter(value, row, index) {
        return [
            '<a class="like" href="javascript:void(0)" title="Like">',
            '<i class="fa fa-heart"></i>',
            '</a>  ',
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fa fa-trash"></i>',
            '</a>'
        ].join('')
    }

    window.operateEvents = {
        'click .like': function(e, value, row, index) {
            alert('You click like action, row: ' + JSON.stringify(row))
        },
        'click .remove': function(e, value, row, index) {
            $table.bootstrapTable('remove', {
                field: 'id',
                values: [row.id]
            })
        }
    }

    function totalTextFormatter(data) {
        return 'Total'
    }

    function totalNameFormatter(data) {
        return data.length
    }

    function totalPriceFormatter(data) {
        var field = this.field
        return '$' + data.map(function(row) {
            return +row[field].substring(1)
        }).reduce(function(sum, i) {
            return sum + i
        }, 0)
    }

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            // 
            search: true,
            searchSelector: '#searchInput',
            // 
            height: 550,
            locale: $('#locale').val(),
            columns: [{
                    field: 'status',
                    // checkbox: true,
                    rowspan: 2,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'user_img',

                    rowspan: 2,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'sid',
                    title: '#',
                    sortable: true,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'name',
                    title: '姓名',
                    sortable: true,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'mobile',
                    title: '手機',
                    sortable: true,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'email',
                    title: 'email',
                    sortable: true,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'nickname',
                    title: '暱稱',
                    sortable: true,
                    align: 'center',
                    valign: 'middle'
                },
                {
                    field: 'price',
                    title: '消費金額',
                    sortable: true,
                    align: 'center',
                    valign: 'middle'
                } {
                    field: 'edit',
                    title: '編輯',
                    // sortable: true,
                    align: 'center',
                    valign: 'middle'
                }

                // 添加其他列的配置...
            ]

        })
        $table.on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table',
            function() {
                $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)

                // save your data, here just save the current page
                selections = getIdSelections()
                // push or splice the selections if you want to save all data selections
            })
        $table.on('all.bs.table', function(e, name, args) {
            console.log(name, args)
        })
        $remove.click(function() {
            var ids = getIdSelections()
            $table.bootstrapTable('remove', {
                field: 'id',
                values: ids
            })
            $remove.prop('disabled', true)
        })
    }

    $(function() {
        initTable()

        $('#locale').change(initTable)
    })
</script>


<?php include '../parts/html-foot.php' ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/locale/zh_TW.js"></script> -->