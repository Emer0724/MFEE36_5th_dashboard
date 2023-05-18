<?php
$title_1 = '新增';
require '../parts/connect-db.php';
require './admin-re1.php';
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sid1 = !empty($_GET['sid']) ? intval($_GET['sid']) : 0;
$ISBN = !empty($_GET['ISBN']) ? intval($_GET['ISBN']) : 0;
// $sql = " SELECT * FROM blog WHERE blog_id={$sid}";
$sql_name = "SELECT * from member where sid={$sid1}";
$isbn_name = "SELECT * from book_info where ISBN={$ISBN}";
$r = $pdo->query($sql_name)->fetch();
$isbn_date = $pdo->query($isbn_name)->fetch()

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
                    <h5 class="card-title">新增書評</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="sid" class="form-label">sid</label>
                            <input type="text" class="form-control border border-secondary-subtle" oninput="getuser(event.target.value)" id="sid" name="sid" data-required="1" value="<?= $sid1 == 0 ? '' : $sid1 ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nickname" class="form-label ">暱稱</label>
                            <input type="text" class="form-control border border-secondary-subtle" id="nickname" name="nickname" data-required="1" value="<?= isset($r['nickname'])  ? $r['nickname'] : ''  ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="ISBN" class="form-label">ISBN</label>
                            <input type="text" class="form-control border border-secondary-subtle" oninput="getisbn(event.target.value)" id="ISBN" name="ISBN" data-required="1" value="<?= $ISBN == 0 ? '' : $ISBN ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="book_name" class="form-label">書名</label>
                            <input type="text" class="form-control border border-secondary-subtle" id="book_name" name="book_name" data-required="1" value="<?= isset($isbn_date['name'])  ? $isbn_date['name'] : ''  ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="rate" class="form-label">評分</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rate" id="rate1" value="1">
                                <label class="form-check-label" for="inlineRadio1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rate" id="rate2" value="2">
                                <label class="form-check-label" for="inlineRadio2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rate" id="rate3" value="3">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rate" id="rate4" value="4">
                                <label class="form-check-label" for="inlineRadio4">4 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rate" id="rate5" value="5">
                                <label class="form-check-label" for="inlineRadio5">5 </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">評論</label>
                            <textarea class="form-control border border-secondary-subtle" id="comment" name="comment" data-required="1"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">編輯</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include '../parts/scripts.php' ?>
<script>
    const nameField = document.querySelector('#comment');
    const infoBar = document.querySelector('#infoBar');
    const fields = document.querySelectorAll('form *[data-required="1"]');



    // if (sid || ISBN)

    function getuser(sid) {
        console.log(sid)
        location.href = `?sid=${sid}`

    }

    function getisbn(ISBN) {

        let sid = document.getElementById('sid').value
        console.log(ISBN)
        location.href = `?sid=${sid}&ISBN=${ISBN}`
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
            fetch('add1-api.php', {
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
                        window.location.replace('book-review.php')
                        setTimeout(() => {
                            window.location.href = "book-review.php"
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