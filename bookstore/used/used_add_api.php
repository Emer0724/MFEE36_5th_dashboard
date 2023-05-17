<?php
require '../parts/connect_db.php';
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
    'detal'=>[],
];
$isPass = false;
date_default_timezone_set('Asia/Taipei');
$today = date("Y-m-d H:i:s");

if (isset($_POST['ISBN']) && isset($_SESSION['sid']['sid'])) {
    $isPass = true;
} else {
    $output['code'] = 410;
};
$sql = "INSERT INTO `used`
(
`client_id`,
`ISBN`,
`review_status`,
`collected_date`,
`updated`
) VALUES (
?,
?,
?,
?,
?
)";
$review_status = '3';
$stmt = $pdo->prepare($sql);
$client_id = $_SESSION['sid']['sid'];
$ISBN = $_POST['ISBN'];
if ($isPass) {
    $stmt->execute([
        $client_id,
        $ISBN,
        $review_status,
        $today,
        $today,
    ]);
    $output['success'] = !!$stmt->rowCount();
       $sql_detal="SELECT *,max(a.collected_date),c.name as book_name,b.name as name_member  FROM used as a left join member as b on a.client_id=b.sid left join book_info as c using(ISBN) where ISBN=$ISBN and client_id= $client_id";
$row=$pdo->query($sql_detal)->fetch();

       $output['detal']=$row;
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
