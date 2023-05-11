<?php
$title = '新增';
require './parts/connect-db.php';

$items = [
    [
        'id' => 2,
        'name' => '看書',
    ],
    [
        'id' => 3,
        'name' => '下棋',
    ],
    [
        'id' => 7,
        'name' => '游泳',
    ],
    [
        'id' => 12,
        'name' => '爬山',
    ],
];


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
                            <label for="" class="form-label">休閒活動1</label>
                            <select class="form-select" name="hobby[first]">

                                <option value="">--請選擇--</option>

                                <?php foreach ($items as $i) : ?>
                                    <option value="<?= $i['id'] ?>"><?= $i['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">休閒活動2</label>
                            <?php foreach ($items as $k => $i) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $i['id'] ?>" id="hobby2<?= $k ?>" name="hobby2[]">
                                    <label class="form-check-label" for="hobby2<?= $k ?>">
                                        <?= $i['name'] ?>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">休閒活動3</label>
                            <?php foreach ($items as $k => $i) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hobby[third]" id="hobby3<?= $k ?>" value="<?= $i['id'] ?>">
                                    <label class="form-check-label" for="hobby3<?= $k ?>">
                                        <?= $i['name'] ?>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>


                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include './parts/scripts.php' ?>
<script>
    function checkForm(event) {
        event.preventDefault();

        const fd = new FormData(document.form1);
        fetch('add-api.php', {
                method: 'POST',
                body: fd, // Content-Type 省略, multipart/form-data
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
            })
            .catch(ex => {
                console.log(ex);

            })



    }
</script>
<?php include './parts/html-foot.php' ?>