<?php
$titla_1 = '新增';
require '../parts/connect-db.php';
require './admin-re.php';
$sid = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;
$sid1 = !empty($_GET['sid']) ? intval($_GET['sid']) : 0;

// $sql = " SELECT * FROM blog WHERE blog_id={$sid}";
$sql_name = "SELECT * from member where sid={$sid1}";

$r = $pdo->query($sql_name)->fetch();

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
                    <h5 class="card-title">新增資料</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <input type="hidden" name="blog_id">
                        <div class="mb-3">
                            <label for="sid" class="form-label">sid</label>
                            <input type="text" class="form-control border border-secondary-subtle" oninput="getuser(event.target.value)" id="sid" name="sid" data-required="1" value="<?= $sid1 == 0 ? '' : $sid1 ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nickname" class="form-label">暱稱</label>
                            <input type="text" class="form-control border border-secondary-subtle" id="nickname" name="nickname" data-required="1" value="<?= isset($r['nickname'])  ? $r['nickname'] : ''  ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">標題</label>
                            <input type="text" class="form-control border border-secondary-subtle" id="title" name="title" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="avatar" id="avatar" accept="image/jpeg">
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">文章</label>
                            <textarea class="form-control border border-secondary-subtle" id="content" name="content" data-required="1"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include '../parts/scripts.php' ?>
<script>
    const nameField = document.querySelector('#title');
    const infoBar = document.querySelector('#infoBar');
    const fields = document.querySelectorAll('form *[data-required="1"]');


    function getuser(sid) {
        console.log(sid)
        location.href = `?sid= ${sid} `
        // fetch(`./add.php?sid=${sid1}`).then(res => res.json()).then(date);
        // method = 'GET';
    }

    function checkForm(event) {
        event.preventDefault();
        for (let f of fields) {
            f.style.border = '1px solid #CCC';
            f.nextElementSibling.innerHTML = ''
        }
        nameField.style.border = '1px solid #CCC';
        nameField.nextElementSibling.innerHTML = ''

        let isPass = true; // 預設值是通過的

        // TODO: 檢查欄位資料
        // for (let f of fields) {
        //     if (!f.value) {
        //         f.style.border = '1px solid red';
        //         f.nextElementSibling.innerHTML = '請填入資料'
        //     }
        // }

        if (nameField.value.length < 2) {
            isPass = false;
            nameField.style.border = '1px solid red';
            nameField.nextElementSibling.innerHTML = '請輸入至少兩個字'
        }

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
                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '上傳成功'
                        infoBar.style.display = 'block';
                        window.location.replace('blog-filter.php')
                        setTimeout(() => {
                            window.location.href = "blog-filter.php"
                        }, 2000);
                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '資料沒有上傳'
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
<?php include '../parts/html-foot.php' ?>