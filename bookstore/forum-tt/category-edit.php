<?php
require "./parts/connection.php";
$title_1 = '論壇管理';
$title_2 = '編輯類別';
?>
<?php
$title_1 = '論壇';
$title_2 = '編輯類別';

?>

<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>

<?php include('./parts/navbar.php') ?>
<?php
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "SELECT * FROM forum_category WHERE sid = {$sid}";

$r = $pdo->query($sql)->fetch();
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">編輯類別</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="category" class="form-label">category</label>
                            <input type="hidden" name="sid" value="<?= $sid ?>">
                            <input type="text" class="form-control bg-light ps-2" id="category" name="category" value="<?= htmlentities($r['category']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none">
                        </div>
                        <button type="submit" class="btn btn-primary">完成</button>
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
            fetch('category-edit-api.php', {
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
                        location.href = 'category.php';

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