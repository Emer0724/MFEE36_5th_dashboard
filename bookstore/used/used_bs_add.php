<?php
require '../parts/connect_db.php';

$output=[
    
        'success' => false,
        'postData' => $_POST,
        'code' => 0,
        'error' => [],
        
   
];

if(isset($_POST['status_id']) && isset($_POST['status_name']) && isset($_POST['status_rule']) && isset($_POST['discount'])){

$isPass=true;

if($isPass){
    $sql="INSERT INTO `book_status`(`status_id`, `status_name`, `status_rule`, `discount`) VALUES (
        ?,?,?,?
    ) ";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        $_POST['status_id'],
        $_POST['status_name'],
        $_POST['status_rule'],
        $_POST['discount']
    ]);
    $output['success']=!!$stmt->rowCount();
}
}
header('Content-Type: application/json');

echo json_encode($output, JSON_UNESCAPED_UNICODE);


?>