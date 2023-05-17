<?php require '../parts/connect_db.php';
$sql= "SELECE * FROM book_status";
// $stmt=$pdo->query($sql)
?>
<?php require '../parts/html-head.php' ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">

<?php require '../parts/aside.php' ?>
<?php require '../parts/navbar.php' ?>

<table id="sort-table" data-toggle="table">
    <thead>
      <tr>
        <th data-field="id" data-sortable="true">ID</th>
        <th data-field="name" data-sortable="true">Item Name</th>
        <th data-field="price" data-sortable="true">Item Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Orange</td>
        <td>102</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Guava</td>
        <td>8</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Grape</td>
        <td>59</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Apple</td>
        <td>45</td>
      </tr>
    </tbody>
  </table>





<?php require '../parts/scripts.php' ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>



<?php require '../parts/html-foot.php' ?>