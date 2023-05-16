<?php
require "./parts/connection.php";
?>

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
                        <button type="submit" class="btn btn-primary">發布</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './parts/scripts.php' ?>
<script>
    const categoryField = document.querySelector('#category');
    const infoBar = document.querySelector('#infoBar');
    // 取得必填欄位
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = ''
        }
        categoryField.style.border = '1px solid #CCC';
        categoryField.nextElementSibling.innerHTML = ''

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


        if (categoryField.value.length < 2) {
            isPass = false;
            categoryField.style.border = '1px solid red';
            categoryField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單
            // const usp = new URLSearchParams(fd); // 可以轉換為 urlencoded 格式
            // console.log(usp.toString());

            fetch('category-create-api.php', {
                method: 'POST',
                body: fd, // Content-Type 省略, multipart/form-data
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
<?php include './parts/html-foot.php' ?>