<?php
require '../parts/connect-db.php';
?>
<?php
# MVC
$pageName = 'list';
$title = '列表';
$perPage = 25; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁
$tital_1 = '訂單管理';
$tital_2 = '訂單管理';
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(1) FROM orders";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];

if ($totalRows) {
  if ($page > $totalPages) {
    header("Location: ?page=$totalPages");
    exit;
  }
  $sql = sprintf("SELECT a.*, b.status FROM orders AS a LEFT JOIN (SELECT DISTINCT `order_id`, `status` FROM order_details) AS b USING (order_id) ORDER BY a.order_id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

  $rows = $pdo->query($sql)->fetchAll();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>
    book書易後台管理系統
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show bg-gray-200">


  <?php
  require '../parts/aside.php';
  ?>
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0  mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">頁面</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">訂單管理</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">訂單管理</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          <div class="input-group input-group-outline">
            <label class="form-label">搜尋</label>
            <input type="text" class="form-control">
          </div>
        </div>
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item px-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0">
              <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
            </a>
          </li>
          <li class="nav-item dropdown pe-2 d-flex align-items-center">
            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
              <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="javascript:;">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mb-1">
                        <span class="font-weight-bold">New message</span> from Laur
                      </h6>
                      <p class="text-xs text-secondary mb-0">
                        <i class="fa fa-clock me-1"></i>
                        13 minutes ago
                      </p>
                    </div>
                  </div>
                </a>
              </li>
              <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="javascript:;">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mb-1">
                        <span class="font-weight-bold">New album</span> by Travis Scott
                      </h6>
                      <p class="text-xs text-secondary mb-0">
                        <i class="fa fa-clock me-1"></i>
                        1 day
                      </p>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a class="dropdown-item border-radius-md" href="javascript:;">
                  <div class="d-flex py-1">
                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                      <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>credit-card</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                              <g transform="translate(453.000000, 454.000000)">
                                <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                              </g>
                            </g>
                          </g>
                        </g>
                      </svg>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mb-1">
                        Payment successfully completed
                      </h6>
                      <p class="text-xs text-secondary mb-0">
                        <i class="fa fa-clock me-1"></i>
                        2 days
                      </p>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item d-flex align-items-center">
            <a href="./pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
              <i class="fa fa-user me-sm-1"></i>
              <span class="d-sm-inline d-none">Sign In</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar 這邊是上面看到那些圖表的區域-->
  <div class="container">
    <div class="row">
      <table data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true" data-search="true" data-show-search-clear-button="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-show-columns-toggle-all="true" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col" data-sortable="true">訂單編號</th>
            <th scope="col" data-sortable="true">客戶編號</th>
            <th scope="col" data-sortable="true">下單日期</th>
            <th scope="col" data-sortable="true">更新日期</th>
            <th scope="col" data-sortable="true">交易狀態</th>
            <th scope="col" data-sortable="true">總金額</th>
            <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              <td><a href="javascript: delete_it(<?= $r['order_id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a></td>
              <td><?= $r['order_id'] ?></td>
              <td><?= $r['client_id'] ?></td>
              <td><?= $r['created'] ?></td>
              <td><?= $r['updated'] ?></td>
              <td><?= $r['status'] ?></td>
              <td><?= $r['price'] ?></td>
              <td><a href="order-edit.php?sid=<?= $r['order_id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
      <div class="container">
        <button type="submit" class="btn btn-primary ">新增</button>

      </div>

    </div>
  </div>








  <?php
  require '../parts/scripts.php';
  ?>
  <script>
    document.querySelector('li.page-item.active a').removeAttribute('href');

    function delete_it(order_id) {
      if (confirm(`是否要刪除編號為 ${order_id} 的資料?`)) {
        location.href = 'order-delete-api.php?order_id=' + order_id;
      }

    }
    document.querySelector('.btn').onclick = add;

    function add() {
      window.location.href = './order-add.php';
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
</body>
<?php
require '../parts/html-foot.php';
?>