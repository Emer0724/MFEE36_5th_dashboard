<?php
include './parts/connect_db.php';
$serial_id = isset($_GET['sid']) ? $_GET['sid'] : 0;
$sql = "SELECT * FROM used join book_info using(ISBN) where serial_id={$serial_id}";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Locstion:used_add.php');
    exit;
}
?>


<?php include './parts/html-head.php' ?>

<?php include './parts/aside.php' ?>
<?php include './parts/navbar.php' ?>
<div class="container">
    <div class="mt-5">
        <form class="d-flex flex-row container-full">
            <div class="col">
                <div class="mb-3">
                    <label for="serial_id " class="form-label">上架流水號:</label>
                    <input type="text" class="form-control " id="serial_id " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $r['serial_id'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="client_id" class="form-label">會員編號:</label>
                    <input type="text" class="form-control" id="client_id" style="background-color: #ECF5FF" value="<?= $r['client_id'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="ISBN" class="form-label">ISBN:</label>
                    <input type="text" class="form-control" id="ISBN" style="background-color: #ECF5FF" value="<?= $r['ISBN'] ?>">
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
                    <input type="text" class="form-control" id="book_status" style="background-color: #ECF5FF" value="<?= $r['book_status'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">書況備註:</label>
                    <input type="text" class="form-control" id="note" style="background-color: #ECF5FF" value="<?= $r['note'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>


                <div class="mb-3">
                    <label for="suggested_price" class="form-label">建議售價:</label>
                    <input type="text" class="form-control" id="suggested_price" style="background-color: #ECF5FF" value="<?= $r['suggested_price'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="sale_price" class="form-label">售價:</label>
                    <input type="text" class="form-control" id="sale_price" style="background-color: #ECF5FF" value="<?= $r['sale_price'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="transaction_status" class="form-label">交易狀態:</label>
                    <input type="text" class="form-control" id="transaction_status" style="background-color: #ECF5FF" value="<?= $r['transaction_status'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="visibility" class="form-label">公開與否:</label>
                    <input type="text" class="form-control" id="visibility" style="background-color: #ECF5FF" value="<?= $r['visibility'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="review_status" class="form-label">審核狀態:</label>
                    <input type="text" class="form-control" id="review_status" style="background-color: #ECF5FF" value="<?= $r['review_status'] ?>">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>






</div>
</div>


<?php include './parts/scripts.php' ?>
<?php include './parts/html-foot.php' ?>