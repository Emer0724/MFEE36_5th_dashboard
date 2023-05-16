<?php
require "./parts/connection.php";
?>

<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>

<?php include('./parts/navbar.php') ?>

<?php
$sid = isset ($_GET['sid']) ? intval($_GET['sid']):0;

$sql = "SELECT * FROM forum WHERE sid = {$sid}";

$r = $pdo->query($sql)->fetch();


$sql_c = "SELECT * FROM forum_category";
$rows_c = $pdo->query($sql_c)->fetchAll();
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">貼文編輯</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <input type="hidden" class="form-control bg-light ps-2" id="sid" name="sid" value="<?= htmlentities($r['sid'])?>"readonly>

                        <div class="mb-3 ">
                            <label for="category" class="form-label d-block">類別</label>
                            <select name="category" id="category">
                                <option value="123">123</option>
                               <?php foreach($rows_c as $c):?>
                                 <option name="category" value="<?=$c['category']?>"><?=$c['category']?></option>
                                 <?php endforeach;?>
                            </select>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label ">標題</label>
                            <input type="text" class="form-control bg-light ps-2" id="title" name="title" value="<?= htmlentities($r['title'])?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="article" class="form-label d-block">內容</label>
                            <textarea name="article" id="article" cols="50" rows="5" class="bg-light "> <?= htmlentities($r['article'])?></textarea>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="created" class="form-label d-block d-none">建立時間</label>
                            <textarea name="created" id="created" cols="50" rows="5" class="bg-light d-none"> <?= htmlentities($r['created'])?></textarea>
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
    const titleField = document.querySelector('#title');
    const infoBar = document.querySelector('#infoBar');
    // 取得必填欄位
    const fields = document.querySelectorAll('form *[data-required="1"]');

    function checkForm(event) {
        event.preventDefault();

        for (let f of fields) {
            f.style.border = '1px solid #ccc';
            f.nextElementSibling.innerHTML = ''
        }
        titleField.style.border = '1px solid #CCC';
        titleField.nextElementSibling.innerHTML = ''

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


        if (titleField.value.length < 2) {
            isPass = false;
            titleField.style.border = '1px solid red';
            titleField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單
            const usp = new URLSearchParams(fd); // 可以轉換為 urlencoded 格式
            console.log(usp.toString());

            fetch('post-edit-api.php', {
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
                        location.href = 'post.php';

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

        } else {
            // 沒通過檢查
        }


    }
</script>
<?php include './parts/html-foot.php' ?>