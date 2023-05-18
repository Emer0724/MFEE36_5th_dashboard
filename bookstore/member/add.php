<?php
// require '../parts/admin-required.php';
$pageName = 'add';
$title1 = '會員';
$title1 = '新增會員';

require '../parts/connect-db.php';

?>
<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>

<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">新增會員</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="rows d-flex justify-content-start">

                            <div class="mb-3">
                                <label for="family_name" class="form-label"><span style="color:red">*</span>姓</label>
                                <input type="text" class="form-control" id="fill" name="family_name" data-required="1">
                                <div class="form-text"></div>
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label"><span style="color:red">*</span>名</label>
                                <input type="text" class="form-control" id="fill" name="first_name" data-required="1">
                                <div class="form-text"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><span style="color:red">*</span>email</label>
                            <input type="text" class="form-control" name="email" data-required="1">
                            <div class="form-text"></div>

                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label"><span style="color:red">*</span>username</label>
                            <input type="text" class="form-control" name="username" data-required="1">
                            <div class="form-text"></div>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><span style="color:red">*</span>密碼</label>
                            <input class="form-control" id="password" name="password" data-required="1" maxlength="50"></input>
                            <div class="form-text"></div>

                        </div>
                        <!-- <div class="mb-3">
                            <label for="password-re" class="form-label"><span style="color:red">*</span>再次輸入密碼</label>
                            <input class="form-control" id="password-re" name="password-re" data-required="1"></input>
                            <div class="form-text"></div>

                        </div> -->

                        <div class="mb-3">
                            <label for="nickname" class="form-label"><span style="color:red">*</span>暱稱</label>
                            <input type="text" class="form-control" id="fill" name="nickname" data-required="1">
                            <div class="form-text"></div>

                        </div>
                        <!-- 
                        <div class="mb-3">
                            <label for="gender" class="form-label">性別</label>
                            <input type="text" class="form-control" name="gender" data-required="1">
                            <div class="form-text"></div>
                        </div> -->

                        <!--  -->
                        <div class="d-flex">
                            <div class="mb-3 mx-1">
                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="男">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    男
                                </label>
                            </div>
                            <div class="mb-3 mx-1">
                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="女">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    女
                                </label>
                            </div>
                            <div class="form-text"></div>
                        </div>
                        <!--  -->


                        <div class="mb-3">
                            <label for="birthday" class="form-label">生日</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            <div class="form-text"></div>

                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">手機</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <div class="form-text"></div>

                        </div>

                        <div class="mb-3">
                            <label for="full_address" class="form-label">地址</label>
                            <input class="form-control" id="full_address" name="full_address"></input>
                            <div class="form-text"></div>

                        </div>

                        <div class="mb-3">
                            <label for="id_num" class="form-label">身份證字號</label>
                            <input class="form-control" id="id_num" name="id_num"></input>
                            <div class="form-text"></div>
                        </div>

                        <!-- <div class="mb-3 mem_avatar">頭像

                            <div class="content"><input name="u_upload" type="file" value="" />
                                <input name="mem_avatar" type="hidden" value="<?php echo $mem_avatar; ?>">
                            </div>
                        </div> -->

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>
                        <button type="submit" class="btn btn-primary">送出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../parts/scripts.php' ?>
<script>
    const nameField = document.querySelector('#fill');
    const infoBar = document.querySelector('#infoBar');
    // 取得必填欄位
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = '';
        }
        nameField.style.border = '1px solid #CCC';
        nameField.nextElementSibling.innerHTML = '';

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


        // if (nameField.value.length < 1) {
        //     isPass = false;
        //     nameField.style.border = '1px solid red';
        //     nameField.nextElementSibling.innerHTML = '請輸入至少一個字';
        // }

        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單
            // const usp = new URLSearchParams(fd); // 可以轉換為 urlencoded 格式
            // console.log(usp.toString());

            fetch('add-api.php', {
                    method: 'POST',
                    body: fd, // Content-Type 省略, multipart/form-data
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger');
                        infoBar.classList.add('alert-success');
                        infoBar.innerHTML = '新增成功';
                        infoBar.style.display = 'block';

                    } else {
                        infoBar.classList.remove('alert-success');
                        infoBar.classList.add('alert-danger');
                        infoBar.innerHTML = '新增失敗';
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000);
                })
                .catch(ex => {
                    console.log(ex);
                    infoBar.classList.remove('alert-success');
                    infoBar.classList.add('alert-danger');
                    infoBar.innerHTML = '新增發生錯誤';
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

<?php include '../parts/html-foot.php' ?>