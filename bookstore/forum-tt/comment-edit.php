<?php
require "./parts/connection.php";
?>

<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>

<?php include('./parts/navbar.php') ?>
<?php
$sid = isset ($_GET['sid']) ? intval($_GET['sid']):0;

$sql = "SELECT * FROM forum_comment WHERE c_sid = {$sid}";

$r = $pdo->query($sql)->fetch();

?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">留言編輯</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <input type="hidden" name="c_sid" value="<?= $sid ?>">
                        <div class="mb-3">
                                <label for="comment" class="form-label d-block">留言</label>
                                <textarea name="comment" id="comment" cols="50" rows="5" ><?= htmlentities($r['comment'])?></textarea>
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
            fetch('comment-edit-api.php', {
                    method: 'POST',
                    body: fd, 
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '編輯成功'
                        infoBar.style.display = 'block';
                        setTimeout(() => {
                            location.href = 'comment.php';
                    }, 2000);

                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '編輯失敗'
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

        } 
    }
</script>
<?php include './parts/html-foot.php' ?>