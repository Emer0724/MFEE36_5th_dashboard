<?php
require './part/connect_db.php';
$sql = "SELECT * FROM `book_info`";
$stmt = $pdo->query($sql)->fetchALL();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <pre><?= print_r($stmt) ?></pre>
</body>

</html>