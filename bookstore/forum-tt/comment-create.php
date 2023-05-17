<?php
require "./parts/connection.php";
?>

<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>

<?php include('./parts/navbar.php') ?>
<?php
$sid = isset ($_GET['c_sid']) ? intval($_GET['c_sid']):0;

$sql = "SELECT * FROM forum_comment WHERE c_sid = {$sid}";

$r = $pdo->query($sql)->fetch();
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增留言</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                       
                        <div class="mb-3">
                            <label for="comment" class="form-label">留言</label>
                            <input type="text" class="form-control bg-light ps-2" id="comment" name="comment">
                            <div class="form-text"></div>
                        </div>
                        <input type="hidden" class="form-control bg-light" id="created" name="created">
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
    const commentField = document.querySelector('#comment');
    const infoBar = document.querySelector('#infoBar');
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = ''
        }
        commentField.style.border = '1px solid #CCC';
        commentField.nextElementSibling.innerHTML = ''

        let isPass = true;
        if (commentField.value.length < 2) {
            isPass = false;
            commentField.style.border = '1px solid red';
            commentField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('comment-create-api.php', {
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
                            location.href = 'comment.php';
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