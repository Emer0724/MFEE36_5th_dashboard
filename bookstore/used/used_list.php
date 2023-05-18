<?php
require '../parts/connect_db.php';
$title_1 = '二手書管理';
$title_2 = '二手書清單';

$select = isset($_GET['select']) ? $_GET['select'] : 'all';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// $serial_id = isset($_GET['serial_id']) ? intval($_GET['serial_id']) : 'none';
// $serial_id_var = "%$serial_id%";
if ($select == 'all') {

  $total = "SELECT count(1) FROM used ";
  $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
  $pre_Page = 10;
  $totalPage = ceil($totalAll / $pre_Page);
  $page = $page > $totalPage ? $totalPage : $page;
  $page = $page < 1 ? 1 : $page;
  $sql = sprintf("SELECT a.*,b.name,c.name as mname FROM used as a JOIN book_info as b using(ISBN) join member as c on a.client_id=c.sid where deleted is Null order by serial_id desc  LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
  $stmt = $pdo->query($sql)->fetchAll();
} else {
  $total = "SELECT count(1) FROM used where review_status={$select} ";
  $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
  $pre_Page = 10;
  $totalPage = ceil($totalAll / $pre_Page);
  $page = $page > $totalPage ? $totalPage : $page;
  $page = $page < 1 ? 1 : $page;
  $sql = sprintf("SELECT a.*,b.name,c.name as mname FROM used as a JOIN book_info as b using(ISBN) join member as c on a.client_id=c.sid where review_status={$select} and deleted is Null order by serial_id desc  LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
  $stmt = $pdo->query($sql)->fetchAll();
}



// if ($select == 'all') {
//   if ($serial_id == 'none') {
//     $total = "SELECT count(1) FROM used ";
//     $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
//     $pre_Page = 10;
//     $totalPage = ceil($totalAll / $pre_Page);
//     $page = $page > $totalPage ? $totalPage : $page;
//     $page = $page < 1 ? 1 : $page;
//     $sql = sprintf("SELECT a.*,b.name FROM used as a JOIN book_info as b using(ISBN) LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
//     $stmt = $pdo->query($sql)->fetchAll();
//   } else {
//     $total = "SELECT count(1) FROM used ";
//     $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
//     $pre_Page = 10;
//     $totalPage = ceil($totalAll / $pre_Page);
//     $page = $page > $totalPage ? $totalPage : $page;
//     $page = $page < 1 ? 1 : $page;
//     $sql = sprintf("SELECT a.*,b.name FROM used as a JOIN book_info as b using(ISBN) where serial_id like $serial_id_var    LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
//     $stmt = $pdo->query($sql)->fetchAll();
//   }
// } else {
//   if ($serial_id == 'none') {
//     $total = "SELECT count(1) FROM used where review_status={$select} ";
//     $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
//     $pre_Page = 10;
//     $totalPage = ceil($totalAll / $pre_Page);
//     $page = $page > $totalPage ? $totalPage : $page;
//     $page = $page < 1 ? 1 : $page;
//     $sql = sprintf("SELECT a.*,b.name FROM used as a JOIN book_info as b using(ISBN) where review_status={$select}  LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
//     $stmt = $pdo->query($sql)->fetchAll();
//   } else {
//     $total = "SELECT count(1) FROM used where review_status={$select} ";
//     $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
//     $pre_Page = 10;
//     $totalPage = ceil($totalAll / $pre_Page);
//     $page = $page > $totalPage ? $totalPage : $page;
//     $page = $page < 1 ? 1 : $page;
//     $sql = sprintf("SELECT a.*,b.name FROM used as a JOIN book_info as b using(ISBN) where review_status={$select} and  serial_id like $serial_id_var  LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
//     $stmt = $pdo->query($sql)->fetchAll();
//   }
// }

// if ($select != '') {
//   $total = "SELECT count(1) FROM used ";
//   $totalAll = $pdo->query($total)->fetch(PDO::FETCH_NUM)[0];
//   $pre_Page = 10;
//   $totalPage = ceil($totalAll / $pre_Page);
//   $page = $page > $totalPage ? $totalPage : $page;
//   $page = $page < 1 ? 1 : $page;
//   $sql = sprintf("SELECT a.*,b.name FROM used as a JOIN book_info as b using(ISBN) WHERE serial_id like '$serial_id'   LIMIT %s,%s", ($page - 1) * $pre_Page, $pre_Page);
//   $stmt = $pdo->query($sql)->fetchAll();
// }



?>
<?php require '../parts/html-head.php' ?>
<?php require '../parts/aside.php' ?>
<?php require '../parts/navbar.php' ?>
<div class="container-full ">

  <div class="row mt-5">
    <div class="col-6 ">
      <form action="used_list.php" method="get" class="ms-2">
        <!-- <label for="serial_id">上架流水號:</label>
        <input type="text" name='serial_id' id='serial_id'> -->
        <label for="select">狀態:</label>
        <select class="form-select-sm" name='select' id='select' value='<?= $select ?>'>
          <option value="all" <?= $select == 'all' ? 'selected' : '' ?>>ALL</option>
          <option value="1" <?= $select == '1' ? 'selected' : '' ?>>已審核</option>
          <option value="2" <?= $select == '2' ? 'selected' : '' ?>>退回</option>
          <option value="3" <?= $select == '3' ? 'selected' : '' ?>>待收書</option>

        </select>
        <button type="submit" class="btn btn-primary" style="display:none" id='button'>篩選</button>
      </form>
    </div>
    <div class="col-6 ">
      <nav aria-label="Page navigation example  " class="ms-2">
        <ul class="pagination  justify-content-end">

          <li class="page-item"><a class="page-link" href="?select=<?= $select ?>&page=<?= ($page - 1) ?>"><i class="fa-solid fa-chevron-left"></i></a></li>
          <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
            <li class="page-item <?= $page == $i ? 'active' : '' ?> "><a class="page-link" href="?select=<?= $select ?>&page=<?= $i ?>"><?= $i ?></a></li>
          <?php endfor; ?>
          <li class="page-item"><a class="page-link" href="?select=<?= $select ?>&page=<?= ($page + 1) ?>"><i class="fa-solid fa-angle-right"></i></a></li>

        </ul>
      </nav>
    </div>

  </div>
  <div class="row ms-2">
    <table class="table order-table">
      <input type="search" class="light-table-filter " data-table="order-table" placeholder="請輸入關鍵字" style="width: 200px;">
      <thead>
        <tr>
          <th scope="col" class='text-center '>刪除</th>
          <th scope="col" class='text-center '>上架流水碼</th>
          <th scope="col" class='text-center '>會員</th>
          <th scope="col" class='text-center '>ISBN</th>
          <!-- <th scope="col" class='text-center '>書名</th> -->
          <th scope="col" class='text-center '>書況</th>
          <th scope="col" class='text-center '>書況備註</th>
          <!-- <th scope="col" class='text-center '>建議售價</th> 
      <th scope="col" class='text-center '>售價</th> -->
          <th scope="col" class='text-center '>交易狀態</th>
          <!-- <th scope="col" class='text-center '>是否公開</th> -->
          <th scope="col " class='text-center '>書況審核狀態</th>
          <th scope="col " class='text-center '>建檔日期</th>
          <th scope="col" class='text-center '>更新日期</th>
          <th scope="col" class='text-center '>檢視/修改</th>

        </tr>
      </thead>
      <tbody>
        <?php foreach ($stmt as $r) : ?>
          <tr>
            <th scope="col" class='text-center '><a href="javascript: delete_it(<?= $r['serial_id'] ?>)" id='deleted'> <i class="fa-solid fa-xmark fs-4"></i></a></th>
            <td scope="col" class='text-center '><?= $r['serial_id'] ?></td>
            <td scope="col" class='text-center'><?= $r['mname'] ?></td>
            <td scope="col" class='text-center'><?= $r['ISBN'] ?></td>
            <!-- <td scope="col" class='text-center'><?= $r['name'] ?></td> -->
            <td scope="col" class='text-center'><?php if ($r['book_status'] == 'A') {
                                                  echo '全新';
                                                } else if ($r['book_status'] == 'B') {
                                                  echo '近全新';
                                                } else if ($r['book_status'] == 'C') {
                                                  echo '良好';
                                                } else if ($r['book_status'] == 'D') {
                                                  echo '普通';
                                                } else if ($r['book_status'] == 'E') {
                                                  echo '差強人意';
                                                } ?>
            <td scope="col" class='text-center'><?= $r['note'] ?></td>
            <td scope="col" class='text-center'><?php if ($r['transaction_status'] == '1') {
                                                  echo '待售中';
                                                } else if ($r['transaction_status'] == '2') {
                                                  echo '已售出';
                                                } else if ($r['transaction_status'] == '3') {
                                                  echo '退回';
                                                }
                                                ?></td>
            <!-- <td scope="col" class='text-center'><?= $r['visibility'] ?></td> -->
            <td scope="col" class='text-center'><?php if ($r['review_status'] == 1) {
                                                  echo '已審核';
                                                } else if ($r['review_status'] == 2) {
                                                  echo '退回';
                                                } else if ($r['review_status'] == 3) {
                                                  echo '待收書';
                                                } ?></td>
            <td scope="col" class='text-center'><?= $r['collected_date'] ?></td>
            <td scope="col" class='text-center'><?= $r['updated'] ?></td>
            <td scope="col" class='text-center'><a href="used_edit.php?serial_id=<?= $r['serial_id'] ?>"><i class="fa-solid fa-pen-to-square fs-4"></i></a></td>
          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>
</div>
<?php require '../parts/scripts.php' ?>
<script>
  (function(document) {
    'use strict';

    // 建立 LightTableFilter
    var LightTableFilter = (function(Arr) {

      var _input;

      // 資料輸入事件處理函數
      function _onInputEvent(e) {
        _input = e.target;
        var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
        Arr.forEach.call(tables, function(table) {
          Arr.forEach.call(table.tBodies, function(tbody) {
            Arr.forEach.call(tbody.rows, _filter);
          });
        });
      }

      // 資料篩選函數，顯示包含關鍵字的列，其餘隱藏
      function _filter(row) {
        var text = row.textContent.toLowerCase(),
          val = _input.value.toLowerCase();
        row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
      }

      return {
        // 初始化函數
        init: function() {
          var inputs = document.getElementsByClassName('light-table-filter');
          Arr.forEach.call(inputs, function(input) {
            input.oninput = _onInputEvent;
          });
        }
      };
    })(Array.prototype);

    // 網頁載入完成後，啟動 LightTableFilter
    document.addEventListener('readystatechange', function() {
      if (document.readyState === 'complete') {
        LightTableFilter.init();
      }
    });

  })(document);
  let select = document.getElementById('select')
  let button = document.getElementById('button')
  select.addEventListener('change', () => {
    button.click();

  })
  let serial_id = document.getElementById('serial_id')
  serial_id.addEventListener('keyup', () => {
    button.click();
  })

  function delete_it(serial_id) {
    if (confirm(`是否要刪除編號為${serial_id}的資料`)) {
      location.href = 'used_delete.php?serial_id=' + serial_id;
    }
  }
</script>
<?php require '../parts/html-foot.php' ?>