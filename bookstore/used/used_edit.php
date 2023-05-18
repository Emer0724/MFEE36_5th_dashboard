<?php
include '../parts/connect_db.php';
$title_1 = '二手書管理';
$title_2 = '二手書檢視/修改';
$serial_id = isset($_GET['serial_id']) ? $_GET['serial_id'] : 0;
$sql = "SELECT * FROM used as a join book_info as b using(ISBN) LEFT JOIN book_status as c  on a.book_status=c.status_id   where serial_id={$serial_id}";
$r = $pdo->query($sql)->fetch();
$sql_status = "SELECT * FROM  book_status where deleted is null ";
$r_detal = $pdo->query($sql_status)->fetchALL();
if (empty($r)) {
    header('Locstion:used_add.php');
    exit;
}
?>


<?php include '../parts/html-head.php' ?>

<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>
<style>
    .backgroung {
        background-color: white;
        box-shadow: 5px 5px 10px gray;
        border-radius: 10px;


    }

    .help {
        color: red;
    }

    .alert {
        width: 400px;
        height: 200px;
        position: absolute;
        top: 50%;
        transform: translate(-200px, -100px);
        left: 50%;

        z-index: 1.5;
        background-color: white;
        box-shadow: 5px 5px 10px gray;

    }

    .none {
        display: none;
    }
</style>
<div class="container">
    <div class="mt-2 backgroung px-5 py-2">
        <h2 class="mt-2">二手書資料檢視/修改</h2>
        <form class="d-flex flex-row container-full " action="used_edit_api.php" method="post" onsubmit="checkform(event)" name="form1">

            <div class="col">
                <div class="mb-3">
                    <label for="serial_id " class="form-label ">上架流水號:</label>
                    <input type="text" class="form-control ps-3 " id="serial_id " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $r['serial_id'] ?>" name="serial_id" readonly>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="client_id" class="form-label ">會員編號:</label>
                    <input type="text" class="form-control ps-3" id="client_id" name="client_id" style="background-color: #ECF5FF" value="<?= $r['client_id'] ?>" readonly>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="ISBN" class="form-label">ISBN:</label>
                    <input type="text" class="form-control ps-3" id="ISBN" name="ISBN" style="background-color: #ECF5FF" value="<?= $r['ISBN'] ?>" readonly>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 ">
                    <label for="ISBN" class="form-label"></label>
                    <div class="fs-3"><?= $r['name'] ?></div>
                </div>
                <div class="d-flex flex-row justify-content-center ">


                    <div class="mb-3 ">
                        <label for="ISBN" class="form-label"></label>
                        <img style=" width:200px ; height:300px ;background-color: #ECF5FF " src="<?= $r['img_url'] ?>"></img>
                    </div>
                </div>



            </div>

            <div class="col ms-5">
                <div class="mb-3">
                    <label for="book_status" class="form-label">書況:</label>
                    <br>
                    <div class="mt-2">
                        <select name="book_status" id="book_status" class="form-select ps-2">
                            <option value="" <?= $r['book_status'] == '' ? 'selectd' : '' ?>>請選擇書況</option>
                            <?php foreach ($r_detal as $r_d) : ?>


                                <option value="<?= $r_d['status_id'] ?>" <?= $r['book_status'] == $r_d['status_id'] ? 'selected' : '' ?>>
                                    <?= $r_d['status_id'] . '-' . $r_d['status_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="ms-2" id='status_rule' style="display:inline"><?= $r['status_rule'] ?></div>
                    </div>


                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">書況備註:</label>
                    <input type="text" class="form-control ps-2" id="note" name="note" style="background-color: #ECF5FF" value="<?= $r['note'] ?>">
                    <div id="noteHelp" class="form-text help"></div>
                </div>


                <div class="mb-3">
                    <label for="suggested_price" class="form-label">建議售價:</label>
                    <input type="text" class="form-control ps-2" id="suggested_price" name="suggested_price" style="background-color: #ECF5FF" value="<?= $r['suggested_price'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="sale_price" class="form-label">售價:</label>
                    <input type="text" class="form-control ps-2" id="sale_price" name="sale_price" style="background-color: #ECF5FF" value="<?= $r['sale_price'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="transaction_status" class="form-label">交易狀態:</label>

                    <select name="transaction_status" id="transaction_status" class="form-select ps-2">
                        <option value="1" <?= $r['transaction_status'] == '1' or $r['transaction_status'] == '' ? 'selected' : '' ?>>1.待售中</option>
                        <option value="2" <?= $r['transaction_status'] == '2' ? 'selected' : '' ?>>2.已售出</option>
                        <option value="3" <?= $r['transaction_status'] == '3' ? 'selected' : '' ?>>3.以書易書</option>
                        <option value="4"></option>
                    </select>
                    <div id="emailHelp" class="form-text "></div>
                </div>
                <div class="mb-3">
                    <label for="visibility" class="form-label">公開與否:</label>

                    <select name="visibility" id="visibility" class="form-select ps-2">
                        <option value="Y" <?= $r['visibility'] == 'Y' or $r['visibility'] == '' ? 'selected' : '' ?>>Y</option>
                        <option value="N" <?= $r['visibility'] == 'N' ? 'selected' : '' ?>>N</option>
                        <option value="4"></option>

                    </select>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="review_status" class="form-label">審核狀態:</label>
                    <select name="review_status" id="review_status" class="form-select ps-2">
                        <option value="1" <?= $r['review_status'] == '1' or $r['review_status'] == '3' ? 'selected' : '' ?>>1.已審核</option>
                        <option value="2" <?= $r['review_status'] == '2' ? 'selected' : '' ?>>2.退回</option>
                        <option value="3">3.待收書</option>
                    </select>

                    <div id="emailHelp" class="form-text"></div>

                </div>
                <button type="submit" class="btn btn-primary ">送出</button>
        </form>
        <div class='none' id='success'>
            <div class='alert d-flex align-items-center justify-content-center '>
                <div class=' d-flex flex-column justify-content-center align-items-center '>
                    <div><i class="fa-regular fa-face-smile-wink text-success fs-1"></i></div>
                    <div class=" fs-2 mt-2">修改成功</div>
                    <div>自動跳轉中...</div>
                </div>
            </div>
        </div>
        <div class='none' id='danger>
        <div class=' alert d-flex align-items-center justify-content-center' id='success'>
            <div class=' d-flex flex-column justify-content-center align-items-center '>
                <div><i class="fa-regular fa-face-sad-tear fs-1 text-info" '></i></i></div> 
            <div class=" fs-2 mt-2" >資料未修改</div>
            <div>再接再厲!你可以的!</div>
            </div>
        </div>
        </div>
        <div class=' none' id='qun'>
                        <div class='alert d-flex align-items-center  justify-content-center' id='success'>
                            <div class=' d-flex flex-column justify-content-center align-items-center '>
                                <div><i class="fa-solid fa-circle-exclamation fs-1 text-info"></i></div>
                                <div class=" fs-2 mt-2">修改發生問題</div>
                                <div>請聯絡管理人員</div>
                            </div>
                        </div>
                </div>

            </div>






        </div>
    </div>


    <?php include '../parts/scripts.php' ?>
    <script>
        let status_rule = document.getElementById('status_rule');
        let book_status = document.getElementById('book_status');
        let book_sgp = document.getElementById('suggested_price');
        let book_sp = document.getElementById('sale_price');
        let visibility = document.getElementById('visibility');
        let transaction_status = document.getElementById('transaction_status');
        let note = document.getElementById('note')
        let noteHelp = document.getElementById('noteHelp')
        let ispass = true;
        let success = document.getElementById('success')
        let danger = document.getElementById('danger')
        let qun = document.getElementById('qun')

        function book_price() {
            status_rule.innerHTML = ''
            status_rule.style.color = 'gray'
            <?php foreach ($r_detal as $r_d) : ?>
                if (book_status.value == '<?= $r_d['status_id'] ?>') {
                    status_rule.textContent = '<?= $r_d['status_rule'] ?>'
                    book_sgp.value = '<?= number_format(number_format($r['list_price'], 2) * number_format($r_d['discount'], 2))  ?>'
                    book_sp.value = '<?= number_format(number_format($r['list_price'], 2) * number_format($r_d['discount'], 2))  ?>'
                }
            <?php endforeach; ?>
        }
        book_status.addEventListener('change', book_price);

        let review_status = document.getElementById('review_status')
        review_status.addEventListener('change', () => {
            if (review_status.value == '2') {
                book_sgp.value = '';
                book_sgp.readOnly = true;
                book_sgp.style.backgroundColor = 'lightgray'
                book_sp.value = '';
                book_sp.readOnly = true;
                book_sp.style.backgroundColor = 'lightgray'
                visibility.value = '4';
                visibility.disable = true;
                transaction_status.value = '4';
                transaction_status.disable = true;
                if (note.value == '') {

                    note.style.border = '1px solid red';
                    noteHelp.innerText = '請輸入書況備註'

                }

            } else {
                book_sgp.readOnly = false;
                book_sgp.readOnly = false;
                book_sgp.style.backgroundColor = '#ECF5FF'
                book_sp.style.backgroundColor = '#ECF5FF'
                visibility.value = '1';
                visibility.disable = false;
                transaction_status.value = 'Y';
                transaction_status.disable = false;
                note.style.border = '0px solid red';
                noteHelp.innerText = ''
                book_status1.value = ''

                return (book_price)

            }
        })

        function checkform(event) {
            event.preventDefault();
            visibility.style.border = '1px solid gray'
            transaction_status.style.border = '1px solid gray'
            book_status.style.border = '1px solid gray'
            if (book_status.value == '') {
                ispass = false;
                book_status.style.border = '1px solid red'
                status_rule.innerHTML = '請選擇書況'
                status_rule.style.color = 'red'
            }
            if (review_status.value == '1') {
                if (transaction_status.value == '') {
                    ispass = false;
                    transaction_status.style.border = '1px solid red'
                    if (visibility.value == '') {
                        ispass = false;
                        visibility.style.border = '1px solid red'
                    }

                } else if (visibility.value == '') {
                    ispass = false;
                    visibility.style.border = '1px solid red'
                }
            }

            if (ispass) {
                const fd = new FormData(document.form1);
                fetch('used_edit_api.php', {
                        method: 'POST',
                        body: fd,
                    }).then(r => r.json())
                    .then(obj => {
                        console.log(obj);
                        if (obj.success) {
                            success.style.display = 'block'
                            setTimeout(() => {
                                success.style.display = 'none'
                                location.href = "used_list.php"
                            }, 2000)
                        } else {
                            danger.style.display = 'block'
                            setTimeout(() => {
                                danger.style.display = 'none'

                            }, 2000)
                        }
                    }).catch(ex => {
                        console.log(ex);
                        qun.style.display = 'block'
                        setTimeout(() => {
                            qun.style.display = 'none'
                        }, 2000)
                    })


            }

        }
    </script>
    <?php include '../parts/html-foot.php' ?>