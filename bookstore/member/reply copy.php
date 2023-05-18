<?php

$pageName = 'reply.php';
$title = '客服回覆';

require '../parts/connect-db.php';


// 獲取 ticket_id 參數
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
} else {
    die("未提供 ticket_id 參數");
}

// 使用 ticket_id 查詢資料庫獲取相關內容
try {
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

        // 進行其他回覆表單的處理
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['comment'])) {
                $comment = $_POST['comment'];
                // 儲存回覆到 reply 欄位
                $stmt = $pdo->prepare("UPDATE ticket SET reply = :reply WHERE ticket_id = :ticket_id");
                $stmt->bindParam(':reply', $comment);
                $stmt->bindParam(':ticket_id', $ticket_id);
                $stmt->execute();
            }

            // 更新 updated 欄位
            $stmt = $pdo->prepare("UPDATE ticket SET updated = CURRENT_TIMESTAMP WHERE ticket_id = :ticket_id");
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->execute();

            // 顯示成功訊息
            echo '<script>
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Your work has been saved",
      showConfirmButton: false,
      timer: 1500
    });
    </script>';
        }
    } else {
        die("找不到相應的資料");
    }
} catch (PDOException $e) {
    die("查詢失敗：" . $e->getMessage());
}

// 關閉資料庫連線
$pdo = null;



?>

<?php include '../parts/html-head.php' ?>
<?php include '../parts/aside.php' ?>
<?php include '../parts/navbar.php' ?>
<?php include '../parts/scripts.php' ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

<link rel="stylesheet" href="path/to/sweetalert2.min.css">
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>


<div class="container">
    <div class="row card">
        <div class="justify-content-center">
            <div class="d-flex card-body justify-content-between" style="border:1px solid red">
                <div class="form" style="border:1px solid red">
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
                        <input type="submit" class="btn btn-primary" value="送出回覆" onclick="showConfirmation()">
                    </form>
                </div>
                <div class="log card w-50" style="border:1px solid red">


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