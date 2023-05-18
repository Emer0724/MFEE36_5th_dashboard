<?php

$pageName = 'reply.php';
$title_1 = '客服';
$title_2 = '客服回覆';

require '../parts/connect-db.php';


// 從 URL 取得 ticket_id 的值
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
} else {
    // 如果 URL 中沒有提供 ticket_id，則回傳錯誤訊息或轉向到其他頁面
    die("No ticket_id provided in the URL.");
}

date_default_timezone_set('Asia/Taipei');
$updated = date("Y-m-d H:i:s");

//...
// 進行其他回覆表單的處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
        $username = $_SESSION['username']; // 使用在 session 中儲存的 username

        // 儲存回覆到 reply 欄位
        $stmt = $pdo->prepare("UPDATE ticket SET reply = :reply, updated_by = :updated_by, updated = CURRENT_TIMESTAMP WHERE ticket_id = :ticket_id");
        $stmt->bindParam(':reply', $comment);
        $stmt->bindParam(':updated_by', $username);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->execute();

        // 在 ticket_log 表中新增一筆記錄
        $stmt = $pdo->prepare("INSERT INTO ticket_log (ticket_id, admin, reply, updated_at) VALUES (:ticket_id, :admin, :reply, CURRENT_TIMESTAMP)");
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':admin', $username);
        $stmt->bindParam(':reply', $comment);
        $stmt->execute();
    }
}

// 使用 ticket_id 查詢資料庫獲取相關內容
$stmt = $pdo->prepare("SELECT * FROM ticket WHERE ticket_id = :ticket_id");
$stmt->bindParam(':ticket_id', $ticket_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // 顯示表頭和內容
    $ticket_id = $result['ticket_id'];
    $category = $result['category'];
    $member_id = $result['member_id'];
    $description = $result['description'];
    $updated_by = $result['updated_by']; // 獲取更新者
    $updated = $result['updated']; // 獲取更新時間

    // 查詢所有關聯的記錄
    $stmt = $pdo->prepare("SELECT * FROM ticket_log WHERE ticket_id = :ticket_id ORDER BY updated_at DESC");
    $stmt->bindParam(':ticket_id', $ticket_id);
    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 在網頁上顯示每一筆記錄
    $logHtml = "";
    foreach ($logs as $log) {
        $logHtml = "";
        foreach ($logs as $log) {
            $logHtml .= "<p>{$log['updated_at']} {$log['admin']} {$log['reply']}</p>";
        }
    }
}

?>
<?php include '../parts/html-head.php' ?>
<?php include '../parts/navbar.php' ?>
<?php include '../parts/scripts.php' ?>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

<link rel="stylesheet" href="path/to/sweetalert2.min.css">

<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>


<div class="container d-flex">
    <div class="row card w-100 h-100">
        <div class="justify-content-center">
            <div class="d-flex card-body justify-content-between ">
                <div class="form w-50">
                    <form method="post" action="reply.php?ticket_id=<?php echo $ticket_id; ?>">
                        <div class="box">客服單號:<?= $ticket_id ?> </div>
                        <div style="display:none">
                            <label for="sid" class="form-label">客服單號</label>
                            <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                            <div class=" form-text">
                            </div>
                        </div>



                        <div class="box">類別:<?= $category ?> </div>
                        <div style="display:none">
                            <label for="sid" class="form-label">類別</label>
                            <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                            <div class=" form-text">
                            </div>
                        </div>

                        <div class="box">會員號碼:<?= $member_id ?> </div>
                        <div style="display:none">
                            <label for="sid" class="form-label">會員號碼</label>
                            <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                            <div class=" form-text">
                            </div>
                        </div>


                        <div class="box">敘述內容:<?= $description ?> </div>
                        <div style="display:none">
                            <label for="sid" class="form-label">敘述內容</label>
                            <input type="text" class="form-control" id="fill" name="sid" data-required="1" value="<?= htmlentities($r['sid']) ?>" readonly>
                            <div class=" form-text">
                            </div>
                        </div>


                        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">
                        <textarea name="comment" rows="4" cols="50" required></textarea>
                        <br>
                        <input type="submit" class="btn btn-primary align-items-center" value="送出回覆" onclick="showConfirmation()">
                    </form>
                </div>
                <div class="log card w-50 shadow-none ms-1" id="ticket-log">
                    <h6 style="color:black bold border-bottom:1px solid black" class="ms-1">客服處理紀錄</h6>
                    <div class="log ms-1"></div>
                    <?php echo $logHtml; ?>
                </div>

            </div>
        </div>


    </div>
</div>

<!--  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function showConfirmation() {
        Swal.fire({
            title: '是否儲存變更?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                // 若使用者按下確認按鈕，執行表單提交操作
                document.forms[0].submit();
            } else if (result.isDenied) {
                // 若使用者按下否定按鈕，顯示訊息框
                Swal.fire('Changes are not saved', '', 'info');
            }
        });
    }
</script>



<?php require '../parts/html-foot.php'; ?>