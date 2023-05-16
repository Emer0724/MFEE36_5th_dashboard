<?php
# MVC
require './parts/connection.php';
?>
<?php include('./parts/html-head.php') ?>

<?php include('./parts/aside.php') ?>

<?php include('./parts/navbar.php') ?>

<div class="card-body d-flex justify-content-evenly align-items-center text-center" style="padding:80px;">
        

        <a href="./post.php" class="btn btn-secondary fs-3 d-flex justify-content-center align-items-center" style="width: 200px; height: 200px; ">貼文管理</a>

        
        <a href="./category.php" class="btn btn-secondary fs-3 d-flex justify-content-center align-items-center" style="width: 200px;height: 200px;">類別管理</a>

        
        <a href="./comment.php" class="btn btn-secondary fs-3 d-flex justify-content-center align-items-center" style="width: 200px;height: 200px;">留言管理</a>
</div>




<?php include './parts/scripts.php' ?>
   
<?php include './parts/html-foot.php' ?>