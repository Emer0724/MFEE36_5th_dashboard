<?PHP
$pageName = 'login';
$title = '登入';
<<<<<<< HEAD:bookstore/login.php
<<<<<<< HEAD
require './parts/connect-db.php';
=======
require './parts/db-connect.php';
>>>>>>> bf05357f11936811acc523ef267285dc72e72df6

=======
require '../parts/connect_db.php';
>>>>>>> b4c8522a41a0ad2f71772527dbbb919a5cd06377:bookstore/used/no_use/login.php
if (isset($_SESSION['admin'])) {
    header('Location: index.php');
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
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">登入管理員</h5>
                    <form name="form1" method="post" onsubmit="checkfrom(event)">
                        <div class="mb-3">
                            <label for="email" class="form-label">email </label>
                            <input type="text
                            " class="form-control" id="email" name="email" data-required="1">
                            <div class="form-text"></div>

                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password </label>
                            <input type="password" class="form-control" id="password" name="password" data-required="1">
                            <div class="form-text"></div>

                        </div>

                        <div class="alert alert-danger" role="alert" id='infoBar' style="display:none">

                        </div>


                        <button type="submit" class="btn btn-primary">登入</button>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD:bookstore/login.php


<<<<<<< HEAD
<?php include './parts/scripts.php' ?>
=======
<?php include './parts/script.php' ?>
>>>>>>> bf05357f11936811acc523ef267285dc72e72df6

=======
</div>
<?php include '../parts/scripts.php' ?>
>>>>>>> b4c8522a41a0ad2f71772527dbbb919a5cd06377:bookstore/used/no_use/login.php
<script>
    const nameField = document.querySelector('#name');
    const fields = document.querySelectorAll('form *[data-required="1"]')
    const infoBar = document.querySelector('#infoBar');

    function checkfrom(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #CCC';
            f.nextElementSibling.innerHTML = '';
        }

        let isPass = true;

        for (let f of fields) {
            if (!f.value) {
                isPass = false;
                f.style.border = '1px solid red';
                f.nextElementSibling.innerHTML = '請填入資料'
            }
        }


        if (isPass) {
            const fb = new FormData(document.form1);
            //const usp = new URLSearchParams(fb);
            // console.log(usp.toString())
            fetch('login-api.php', {
                    method: 'POST',
                    body: fb,
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infoBar.classList.remove('alert-danger');
                        infoBar.classList.add('alert-success');
                        infoBar.innerHTML = '登入成功'
                        infoBar.style.display = 'block';
                        setTimeout(() => {
                            location.href = 'index.php';
                        }, 2000);
                    } else {
                        infoBar.classList.remove('alert-success');
                        infoBar.classList.add('alert-danger');
                        infoBar.innerHTML = '登入失敗'
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000)
                }).catch(ex => {
                    console.log(ex);
                    infoBar.classList.remove('alert-success');
                    infoBar.classList.add('alert-danger');
                    infoBar.innerHTML = '發生錯誤'
                    infoBar.style.display = 'block';
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000)
                })

        }



    }
</script>
<?php include '../parts/html-foot.php' ?>