<?php
// require '../parts/admin-required.php';
$title_1 = '會員管理';
$title_2 = '編輯';
require '../parts/connect-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT *FROM member WHERE sid={$sid}";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: list-admin.php');
    exit;
}



?>
<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>
<?php include '../parts/scripts.php' ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">



<link rel="stylesheet" href="path/to/sweetalert2.min.css">
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>

<!-- <script>
    function stringToHslColor($str, $s, $l) {
        $hash = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $hash = ord($str[$i]) + (($hash << 5) - $hash);
        }

        $h = $hash % 360;
        return 'hsl('.$h.
        ','.$s.
        '%, '.$l.
        '%)';
    }
</script> -->

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">

                <div class="card-body row justify-content-start">
                    <div class="d-flex justify-content-between">

                        <h5 class="card-title">編輯資料</h5>
                        <div class="box">會員號碼:<?= $r['sid'] ?> </div>
                        <div style="display:none">
                            <label for="sid" class="form-label"><span style="color:red">*</span>會員號碼</label>
                            <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                            <div class=" form-text">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="profile-image">
                        <?php
                        // Get the first character of the email
                        // $initial = mb_substr($r['email'], 0, 1, "UTF-8");
                        // $initial = strtoupper($initial);

                        // Use the initial to generate the color
                        // $color = stringToHslColor($initial, 50, 50);
                        ?>
                        <div class='user-image' style='background-color: <?= $color ?>;'><?= $initial ?></div>
                    </div> -->

                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="rows d-flex justify-content-start">


                            <div style="display:none">
                                <label for="sid" class="form-label"><span style="color:red">*</span>會員號碼</label>
                                <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                                <div class="form-text">
                                </div>
                            </div>



                            <div class="mb-3">
                                <label for="family_name" class="form-label"><span style="color:red">*</span>姓</label>
                                <input type="text" class="form-control" id="fill" name="family_name" data-required="1" value="<?= htmlentities($r['family_name']) ?>">
                                <div class="form-text">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label"><span style="color:red">*</span>名</label>
                                <input type="text" class="form-control" id="fill" name="first_name" data-required="1" value="<?= htmlentities($r['first_name']) ?>">
                                <div class="form-text"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><span style="color:red">*</span>email</label>
                            <input type="text" class="form-control" name="email" data-required="1" value="<?= htmlentities($r['email']) ?>">
                            <div class="form-text"></div>

                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label"><span style="color:red">*</span>username</label>
                            <input type="text" class="form-control" name="username" data-required="1" value="<?= htmlentities($r['username']) ?>">
                            <div class="form-text"></div>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><span style="color:red">*</span>密碼</label>
                            <input type="password" class="form-control" id="password" name="password" data-required="1" maxlength="50" value="<?= htmlentities($r['password']) ?>"></input>
                            <div class="form-text"></div>

                        </div>
                        <!-- <div class="mb-3">
                            <label for="password-re" class="form-label"><span style="color:red">*</span>再次輸入密碼</label>
                            <input class="form-control" id="password-re" name="password-re" data-required="1"></input>
                            <div class="form-text"></div>

                        </div> -->

                        <div class="mb-3">
                            <label for="nickname" class="form-label"><span style="color:red">*</span>暱稱</label>
                            <input type="text" class="form-control" id="fill" name="nickname" data-required="1" value="<?= htmlentities($r['nickname']) ?>">
                            <div class="form-text"></div>

                        </div>

                        <div class="d-flex">
                            <div class="mb-3 mx-1">
                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="男" <?= $r['gender'] == '男' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    男
                                </label>
                            </div>
                            <div class="mb-3 mx-1">
                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="女" <?= $r['gender'] == '女' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    女
                                </label>
                            </div>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="id_num" class="form-label">身份證字號</label>
                            <input class="form-control" id="id_num" name="id_num"></input>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="birthday" class="form-label">生日</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlentities($r['birthday']) ?>">
                            <div class="form-text"></div>

                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">手機</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($r['mobile']) ?>">
                            <div class="form-text"></div>

                        </div>

                        <div class="mb-3">
                            <label for="full_address" class="form-label">地址</label>
                            <input class="form-control" id="full_address" name="full_address" value="<?= htmlentities($r['full_address']) ?>"></input>
                            <div class="form-text"></div>

                        </div>


                        <div class="btn-group d-flex justify-content-around">
                            <div>
                                <button type="submit" class="btn btn-primary">送出</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary" onclick="delete_it(<?= $r['sid'] ?>)">刪除會員資料</button>

                            </div>
                        </div>



                        <br>

                        <div class="box">Last updated:<?= $r['updated'] ?> </div>
                        <div style="display:none">
                            <label for="sid" class="form-label me-auto">上次更新日期</label>
                            <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                            <div class=" form-text">
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../parts/html-foot.php' ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
</script>

<script>
    const nameField = document.querySelector('#fill');
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


        // 檢查必填欄位
        for (let f of fields) {
            if (!f.value) {
                isPass = false;
                f.style.border = '1px solid red';
                f.nextElementSibling.innerHTML = '請填入資料'
            }
        }


        if (nameField.value.length < 1) {
            isPass = false;
            nameField.style.border = '1px solid red';
            nameField.nextElementSibling.innerHTML = '請輸入至少一個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單
            // const usp = new URLSearchParams(fd); // 可以轉換為 urlencoded 格式
            // console.log(usp.toString());


            Swal.fire({
                title: '你確定要保存修改嗎？',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '保存',
                denyButtonText: `取消變更`,
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('edit-api.php', {
                            method: 'POST',
                            body: fd,
                        }).then(r => r.json())
                        .then(obj => {
                            if (obj.success) {
                                Swal.fire('保存成功!', '', 'success');
                            } else {
                                Swal.fire('數據沒有被編輯', '', 'info');
                            }
                        })
                        .catch(ex => {
                            Swal.fire('編輯發生錯誤', '', 'error');
                        })
                } else if (result.isDenied) {
                    Swal.fire('更改未被保存', '', 'info')
                }
            })
        } else {
            //沒通過檢查
        }
    }



    function delete_it(sid) {
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
                location.href = 'delete.php?sid=' + sid;
            }
        });
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/locale/zh_TW.js"></script>