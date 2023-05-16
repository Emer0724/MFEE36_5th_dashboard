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
                    <h5 class="card-title">新增公告</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <input type="hidden" class="form-control bg-light ps-2" id="member-name" name="member-name">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">標題</label>
                            <input type="text" class="form-control bg-light ps-2" id="title" name="title">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="article" class="form-label d-block">內容</label>
                            <textarea name="article" id="article" cols="50" rows="5" class="bg-light"></textarea>
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
    const titleField = document.querySelector('#title');
    const infoBar = document.querySelector('#infoBar');
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();
            let isPass = true;
        for (let f of fields) {
            if(!f.value){
            isPass = false;
            f.style.border = '1px solid red';
            f.nextElementSibling.innerHTML = '請填入資料'
         }else{
            f.style.border ='1px solid #CCC';
         }
        };

        if (titleField.value.length < 2) {
            isPass = false;
            titleField.style.border = '1px solid red';
            titleField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('post-create-api.php', {
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
                        setTimeout(() => {
                            location.href = 'post.php';
                    }, 2000);
                        

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

        } 


    }
</script>
<?php include './parts/html-foot.php' ?>