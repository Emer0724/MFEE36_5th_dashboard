<?php
include '../parts/connect-db.php';
// $select = isset($_GET['select']) ? $_GET['select'] : 'all';


$sql = "SELECT * FROM used  ";
$stmt = $pdo->query($sql)->fetchAll();
?>
<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>
<div class="container ">

  <div class="row mt-5">
    <div class="col-6">
      <div class="col-6 ">
        <nav aria-label="Page navigation example ">
          <ul class="pagination  justify-content-end">
            <!-- 
          <li class="page-item"><a class="page-link" href="?page=<?= ($page - 1) ?>">Previous</a></li>
          <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
            <li class="page-item <?= $page == $i ? 'active' : '' ?> "><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
          <?php endfor; ?>
          <li class="page-item"><a class="page-link" href="?page=<?= ($page + 1) ?>">Next</a></li> -->

          </ul>
        </nav>
      </div>

    </div>
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">上架流水碼</th>
            <th scope="col">會員編碼</th>
            <th scope="col">ISBN</th>
            <th scope="col">書名</th>
            <th scope="col">書況</th>
            <th scope="col">書況備註</th>
            <!-- <th scope="col">建議售價</th> 
      <th scope="col">售價</th> -->
            <th scope="col">交易狀態</th>
            <!-- <th scope="col">是否公開</th> -->
            <th scope="col">書況審核狀態</th>
            <th scope="col">建檔日期</th>
            <th scope="col">更新日期</th>
            <th scope="col">檢視/修改</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($stmt as $r) : ?>
            <tr>
              <td scope="col" class='text-center '><?= $r['serial_no'] ?></td>
              <td scope="col" class='text-center'><?= $r['client_id'] ?></td>
              <td scope="col" class='text-center'><?= $r['ISBN'] ?></td>
              <td scope="col" class='text-center'><?= $r['book_status'] ?></td>
              <td scope="col" class='text-center'><?= $r['note'] ?></td>
              <td scope="col" class='text-center'><?= $r['transaction_status'] ?></td>
              <td scope="col" class='text-center'><?= $r['visibility'] ?></td>
              <td scope="col" class='text-center'><?= $r['review_status'] ?></td>
              <td scope="col" class='text-center'><?= $r['collected_date'] ?></td>
              <td scope="col" class='text-center'><?= $r['up_date'] ?></td>
              <td scope="col" class='text-center'><a href="#"><i class="fa-solid fa-pen-to-square fs-4"></i></a></td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>
  <?php include '../parts/scripts.php' ?>
  <?php include '../parts/html-foot.php' ?>