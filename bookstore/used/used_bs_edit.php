<?php
require '../parts/connect_db.php';

$sql="SELECT * FROM book_status where status_id = '{$_GET['status_id']}'";
$stmt=$pdo->query($sql)->fetch();

?>
<?php require '../parts/html-head.php' ?>

<?php require '../parts/aside.php' ?>
<?php require '../parts/navbar.php' ?>
<style>
.backgroung {
        background-color: white;
        box-shadow: 5px 5px 10px gray;
        border-radius: 10px;


    }
    </style>

<div class="container backgroung w-50  ">
    <form action="">
        <h2>書況修改</h2>
        <div class=" d-flex justify-content-center ">
                <div class="mb-3 w-50" >
                    <label for="serial_id " class="form-label ">書況ID:</label>
                    <input type="text" class="form-control ps-3 " id="status_id " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt['status_id'] ?>" name="status_id" >
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 w-50">
                    <label for="serial_id " class="form-label ">書況名稱:</label>
                    <input type="text" class="form-control ps-3 " id="status_name " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt['status_name'] ?>" name="status_name" >
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 w-50">
                    <label for="serial_id " class="form-label ">規則</label>
                    <input type="text" class="form-control ps-3 " id="status_rule " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt['status_rule'] ?>" name="status_rule" >
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 w-50">
                    <label for="serial_id " class="form-label ">折扣</label>
                    <input type="text" class="form-control ps-3 " id="discount " aria-describedby="emailHelp" style="background-color: #ECF5FF" value="<?= $stmt['discount'] ?>" name="discount" >
                    <div id="emailHelp" class="form-text"></div>
                </div>
                </div>
                <button type="submit" class="btn btn-primary ">送出</button>
    </form>
</div>
<?php require '../parts/scripts.php' ?>
<?php require '../parts/html-foot.php' ?>