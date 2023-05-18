<?php

if (!isset($_GET["sid"])) {
    exit;
}

$id = $_GET["sid"];

require_once("../connect-db.php");
$sql = "SELECT * FROM member WHERE sid='$id' AND valid=1";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

// if (!$row) {
//     header("location: 404.php");
// }

?>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="updateUser.php" method="post">
                <table class="table table-bordered  text-nowrap">
                    <input type="hidden" name="id" value="<?= $row["sid"] ?>">
                    <tr>
                        <th>會員編號</th>
                        <td><?= $row["sid"] ?></td>
                    </tr>
                    <tr>
                        <th>名字</th>
                        <td><input class="form-control" type="text" name="user_name" value="<?= $row["first_name"] ?>"></td>
                    </tr>
                    <tr>
                        <th>身分證字號</th>
                        <td><?= $row["id_num"] ?></td>
                    </tr>
                    <tr>
                        <th>暱稱</th>
                        <td><input class="form-control" type="text" name="nick_name" value="<?= $row["nick_name"] ?>"></td>
                    </tr>
                    <tr>
                        <th>出生年月日</th>
                        <td><input class="form-control" type="date" name="user_bir" value="<?= $row["user_bir"] ?>"></td>
                    </tr>
                    <tr>
                        <th>手機號碼</th>
                        <td><input class="form-control" type="tel" name="user_phone" value="<?= $row["user_phone"] ?>"></td>
                    </tr>
                    <tr>
                        <th>電子信箱</th>
                        <td><input class="form-control" type="email" name="user_mail" value="<?= $row["user_mail"] ?>"></td>
                    </tr>
                    <tr>
                        <th>會員等級</th>
                        <td><?= $row["user_level"] ?></td>
                    </tr>
                    <tr>
                        <th>創建日期</th>
                        <td><?= $row["user_create_time"] ?></td>
                    </tr>
                </table>
                <div class="py-2">
                    <button type="submit" class="btn btn-info text-white">儲存</button>
                    <a class="btn btn-info text-white" href="user.php?id=<?= $row["user_id"] ?>">取消</a>
                </div>
            </form>
        </div>
    </div>
</div>

















<?php
require './parts/admin-required.php';
$title = '編輯';
require './parts/connect-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT *FROM address_book WHERE sid={$sid}";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: list.php');
    exit;
}



?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">編輯資料</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">* name</label>
                            <input type="text" class="form-control" id="name" name="name" data-required="1" value="<?= htmlentities($r['name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= htmlentities($r['email']) ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($r['mobile']) ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlentities($r['birthday']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">address</label>
                            <textarea class="form-control" id="address" name="address" data-required="1"><?= $r['address'] ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">編輯</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include './parts/script.php' ?>
<script>
    const nameField = document.querySelector('#name');
    const infoBar = document.querySelector('#infoBar');
    // 取得必填欄位
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = ''
        }
        nameField.style.border = '1px solid #CCC';
        nameField.nextElementSibling.innerHTML = ''

        let isPass = true; // 預設值是通過的

        // TODO: 檢查欄位資料

        /*
        // 檢查必填欄位
        for(let f of fields){
            if(! f.value){
                isPass = false;
                f.style.border = '1px solid red';
                f.nextElementSibling.innerHTML = '請填入資料'
            }
        }
        */


        if (nameField.value.length < 2) {
            isPass = false;
            nameField.style.border = '1px solid red';
            nameField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單
            // const usp = new URLSearchParams(fd); // 可以轉換為 urlencoded 格式
            // console.log(usp.toString());

            fetch('edit-api.php', {
                    method: 'POST',
                    body: fd, // Content-Type 省略, multipart/form-data
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '編輯成功'
                        infoBar.style.display = 'block';

                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '資料沒有編輯'
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000);
                })
                .catch(ex => {
                    console.log(ex);
                    infoBar.classList.remove('alert-success')
                    infoBar.classList.add('alert-danger')
                    infoBar.innerHTML = '編輯發生錯誤'
                    infoBar.style.display = 'block';
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000);
                })

        } else {
            // 沒通過檢查
        }


    }
</script>
<?php include './parts/html-foot.php' ?>