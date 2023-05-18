<?php
<<<<<<<< HEAD:bookstore/forum-tt/category-create.php
require "./parts/connection.php";
?>
========
$pageName = 'login';
$title = '登入';
require '../parts/connect-db.php';

if (isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

?>
<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>
>>>>>>>> 65cf96b3098cc70122d151b999ff15acf4046b32:bookstore/member/login.php

<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>

<?php include('./parts/navbar.php') ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增類別</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="category" class="form-label">category</label>
                            <input type="text" class="form-control bg-light ps-2" id="category" name="category">
                            <div class="form-text"></div>
                        </div>
                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none">
                        </div>
<<<<<<<< HEAD:bookstore/forum-tt/category-create.php
                        <button type="submit" class="btn btn-primary">發布</button>
========


                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">登入</button>
>>>>>>>> 65cf96b3098cc70122d151b999ff15acf4046b32:bookstore/member/login.php
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<<< HEAD:bookstore/forum-tt/category-create.php
<?php include './parts/scripts.php' ?>
========


<?php include '../parts/scripts.php' ?>

>>>>>>>> 65cf96b3098cc70122d151b999ff15acf4046b32:bookstore/member/login.php
<script>
    const categoryField = document.querySelector('#category');
    const infoBar = document.querySelector('#infoBar');
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = ''
        }
        categoryField.style.border = '1px solid #CCC';
        categoryField.nextElementSibling.innerHTML = ''

        let isPass = true; 

        if (categoryField.value.length < 2) {
            isPass = false;
            categoryField.style.border = '1px solid red';
            categoryField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('category-create-api.php', {
                method: 'POST',
                body: fd, 
            }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '新增成功'
                        infoBar.style.display = 'block';
                        location.href = 'category.php';

                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '新增失敗'
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                        location.href = "index_.php"
                    }, 2000);
                })
                .catch(ex => {
                    console.log(ex);
                    infoBar.classList.remove('alert-success')
                    infoBar.classList.add('alert-danger')
                    infoBar.innerHTML = '新增發生錯誤'
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