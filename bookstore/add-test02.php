<?php
$title = '新增';
require './parts/connect-db.php';

$sql = "SELECT * FROM categories";
$rows = $pdo->query($sql)->fetchAll();


?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
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
                    <h5 class="card-title">測試資料</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="" class="form-label">1</label>
                            <select class="form-select" name="">

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">2</label>
                            <select class="form-select" name="">

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include './parts/script.php' ?>
<script>
    const rows = <?= json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;
</script>
<?php include './parts/html-foot.php' ?>