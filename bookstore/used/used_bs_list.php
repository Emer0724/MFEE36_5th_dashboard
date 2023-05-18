<?php
$title_1 = '二手書管理';
$title_2 = '書況管理';

require '../parts/connect_db.php';
$sql = "SELECT * FROM book_status where deleted is null";
$stmt = $pdo->query($sql)->fetchALL();



if (isset($_GET['status_id'])) {
    $status_id = $_GET['status_id'];
    $sql_1 = "SELECT * FROM book_status where status_id ='{$status_id}' and deleted is null ";
    $stmt2 = $pdo->query($sql_1)->fetch();
}



?>
<?php require '../parts/html-head.php' ?>

<?php require '../parts/aside.php' ?>
<?php require '../parts/navbar.php' ?>
<style>
    .alert {
        width: 400px;
        height: 200px;
        position: absolute;
        top: 50%;
        transform: translate(-200px, -100px);
        left: 50%;

        z-index: 1.5;
        background-color: white;
        box-shadow: 5px 5px 10px gray;

    }

    .none {
        display: none;
    }


    .backgroung {
        background-color: white;
        box-shadow: 5px 5px 10px gray;
        border-radius: 10px;
        width: 400px;
        height: 600px;
        position: absolute;
        top: 50%;
        transform: translate(-200px, -200px);
        left: 50%;
        z-index: 1.2;



    }

    .black {
        background-color: gray;
        opacity: 0.6;
    }

    .weight {
        width: 200px;
    }
</style>
<div class="container position-relative" id="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class='text-center '>刪除</th>
                <th scope="col" class='text-center '>書況ID</th>
                <th scope="col" class='text-center '>書況名稱</th>
                <th scope="col" class='text-center '>規則</th>
                <th scope="col" class='text-center '>折價</th>
                <th scope="col" class='text-center '>修改</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($stmt as $r) : ?>
                <tr>

                    <td scope="col" class='text-center '><a href="javascript: delete_it('<?= $r['status_id'] ?>')" id='deleted'> <i class="fa-solid fa-xmark fs-4"></i></a></td>
                    <td scope="col" class='text-center ' ondblclick="Show(this)"><?= $r['status_id'] ?></td>
                    <td scope="col" class='text-center ' ondblclick="Show(this)"><?= $r['status_name'] ?></td>
                    <td scope="col" class='text-center ' ondblclick="Show(this)"><?= $r['status_rule'] ?></td>
                    <td scope="col" class='text-center ' ondblclick="Show(this)"><?= $r['discount'] ?></td>
                    <td scope="col" class='text-center' ondblclick="Show(this)"><a href="used_bs_list.php?status_id=<?= $r['status_id'] ?>"><i class="fa-solid fa-pen-to-square fs-4"></i></a></td>
                </tr>
            <?php endforeach; ?>
            <form action="used_bs_add.php" method="post" onsubmit="checkform(event)" name="form1">
                <tr>
                    <td scope="col" class='text-center '>新增</td>
                    <td scope="col" class='text-center '><input type="text" name="status_id" style="width: 50px;"></td>
                    <td scope="col" class='text-center '><input type="text" name="status_name" style="width: 100px;"></td>
                    <td scope="col" class='text-center '><input type="text" name="status_rule" style="width: 250px;"></td>
                    <td scope="col" class='text-center '><input type="text" name="discount" style="width: 50px;"></td>
                    <td scope="col" class='text-center'><button type="submit" class="btn btn-primary">送出</button> </td>
                </tr>

            </form>

        </tbody>
    </table>
</div>

<div class="container backgroung   py-5 none" id='edit'>
    <div class='d-flex justify-content-center'>
        <form action="used_bs_edit_1.php" method="post" name='form2' onsubmit="checkform2(event)">
            <h2>書況修改</h2>
            <div>
                <div class="mb-3 weight">
                    <label for="serial_id " class="form-label fs-5 ">書況ID:</label>
                    <input type="text" class="form-control ps-3 " id="status_id " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt2['status_id'] ?>" name="status_id">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 weight">
                    <label for="serial_id " class="form-label fs-5 ">書況名稱:</label>
                    <input type="text" class="form-control ps-3 " id="status_name " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt2['status_name'] ?>" name="status_name">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 weight">
                    <label for="serial_id " class="form-label  fs-5">規則</label>
                    <textarea class="form-control ps-3 " id="status_rule " aria-describedby="emailHelp" style="background-color: #ECF5FF" name="status_rule"><?= $stmt2['status_rule'] ?></textarea>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 weight">
                    <label for="serial_id " class="form-label fs-5 ">折扣</label>
                    <input type="text" class="form-control ps-3 " id="discount " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt2['discount'] ?>" name="discount">
                    <div id="emailHelp" class="form-text"></div>
                </div>

            </div>


            <button type="submit" class="btn btn-primary  ms-5 ">修改</button>
    </div>
    </form>

</div>


</div>
<div class='none' id='success'>
    <div class='alert d-flex align-items-center justify-content-center '>
        <div class=' d-flex flex-column justify-content-center align-items-center '>
            <div><i class="fa-regular fa-face-smile-wink text-success fs-1"></i></div>
            <div class=" fs-2 mt-2">上架新增成功</div>
            <div>自動跳轉中...</div>
        </div>
    </div>
</div>
<div class='none' id='danger'>
    <div class=' alert d-flex align-items-center justify-content-center' id='success'>
        <div class=' d-flex flex-column justify-content-center align-items-center '>
            <div><i class="fa-regular fa-face-sad-tear fs-1 text-info"></i></i></div>
            <div class=" fs-2 mt-2">上架新增失敗</div>
            <div>再接再厲!你可以的!</div>
        </div>
    </div>
</div>
<div class=' none' id='qun'>
    <div class='alert d-flex align-items-center  justify-content-center' id='success'>
        <div class=' d-flex flex-column justify-content-center align-items-center '>
            <div><i class="fa-solid fa-circle-exclamation fs-1 text-info"></i></div>
            <div class=" fs-2 mt-2">上架發生問題</div>
            <div>請聯絡管理人員</div>
        </div>
    </div>
</div>





<?php require '../parts/scripts.php' ?>
<script>
    let success = document.getElementById('success')
    let danger = document.getElementById('danger')
    let qun = document.getElementById('qun')
    let edit = document.getElementById('edit')
    let container = document.getElementById('container')

    let url = new URL(window.location.href);
    let searchParams = new URLSearchParams(url.search);
    let status_id = searchParams.get('status_id');

    edit.style.display = 'none'
    if (status_id) {
        edit.style.display = 'block'

    } else {
        edit.style.display = 'none'
    }

    // function Show(element) {
    //     var oldhtml = element.innerHTML;
    //     if (oldhtml == null || oldhtml.length == 0) {
    //         return alert("不能为空!");
    //     }

    //     var newInput = document.createElement('input');
    //     newInput.type = 'text';
    //     newInput.value = oldhtml;
    //     newInput.onblur = function() {
    //         element.innerHTML = this.value == oldhtml ? oldhtml : this.value;
    //     }

    //     element.innerHTML = '';
    //     element.appendChild(newInput);
    //     newInput.setSelectionRange(0, oldhtml.length);
    //     newInput.focus();
    // }

    function checkform(event) {
        event.preventDefault();
        let ispass = true;

        if (ispass) {
            const fd = new FormData(document.form1);
            fetch('used_bs_add.php', {
                    method: 'POST',
                    body: fd,
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        success.style.display = 'block'
                        setTimeout(() => {
                            success.style.display = 'none'
                            location.href = "used_bs_list.php"
                        }, 2000)
                    } else {
                        danger.style.display = 'block'
                        setTimeout(() => {
                            danger.style.display = 'none'

                        }, 2000)
                    }
                }).catch(ex => {
                    console.log(ex);
                    qun.style.display = 'block'
                    setTimeout(() => {
                        qun.style.display = 'none'
                    }, 2000)
                })


        }

    }

    function checkform2(event) {
        event.preventDefault();
        let ispass = true;

        if (ispass) {
            const fd1 = new FormData(document.form2);
            fetch('used_bs_edit_1.php', {
                    method: 'POST',
                    body: fd1,
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        success.style.display = 'block'
                        setTimeout(() => {
                            success.style.display = 'none'
                            location.href = "used_bs_list.php"
                        }, 2000)
                    } else {
                        danger.style.display = 'block'
                        setTimeout(() => {
                            danger.style.display = 'none'

                        }, 2000)
                    }
                }).catch(ex => {
                    console.log(ex);
                    qun.style.display = 'block'
                    setTimeout(() => {
                        qun.style.display = 'none'
                    }, 2000)
                })


        }

    }

    function delete_it(status_id) {
        if (confirm(`是否要刪除編號為${status_id}的資料`)) {
            location.href = 'used_bs_delete.php?status_id=' + status_id;
        }
    }
</script>
</script>

<?php require '../parts/html-foot.php' ?>