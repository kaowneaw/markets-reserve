<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
require_once("libs/PromptPay-QR-generator-master/lib/PromptPayQR.php");

// Start the session
session_start(); // Starting Session

if (!$_SESSION["user"]) {  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

$userId = $_SESSION['user']->users_id;
$sql = "SELECT * FROM users WHERE users_id = '$userId' limit 1";
$result = $conn->query($sql);
$userObj = '';
if ($result->num_rows > 0) {
    while ($obj = mysqli_fetch_object($result)) {
        $userObj = $obj;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// generate prompt pay qr code
$PromptPayQR = new PromptPayQR(); // new object
$PromptPayQR->size = 8; // Set QR code size to 8
$PromptPayQR->id = $_SESSION['user']->tel; // PromptPay ID
$PromptPayQR->amount = 1;
$qrSrc = $PromptPayQR->generate();


if(isset($_POST['isUseQR'])) {
    $isUseQr = $_POST['isUseQR']; // 0 = use 1 = not use
    $isUseQr = 1 - $isUseQr; // สลับ status
    $sql = "UPDATE users SET isUsePromtPay = '$isUseQr' WHERE users_id = '$userId';";
    if ($conn->query($sql) === TRUE) {
        echo $sql;
        header('Location: my_account_bank_promtpay.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Market</title>
</head>
<body>
<?php require('./common/nav.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="pull-left text-white">รายการบัญชีธนาคาร</h3>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">PromptPay QR Code</a></li>
        <li><a href="my_account_bank.php">รายการบัญชีธนาคาร</a></li>
    </ul>
    <div id="container" class="panel">
        <div class="card-body">
            <div class="form-group">* กรุณาใช้เบอร์โทรศัพท์ที่ลงทะเบียนกับ PromptPay ในข้อมูลโปรไฟล์ของท่าน</div>
            <form method="POST">
                <div>
                    <input type ="hidden" name="isUseQR" value="<?php echo $userObj->isUsePromtPay ?>">
                    <?php
                        if($userObj->isUsePromtPay == 0) {
                            echo '<button type="submit" class="btn btn-success pull-left">เปิดใช้งาน</button>';
                        } else {
                            echo '<button type="submit" class="btn btn-warning pull-left">ปิดใช้งาน</button>';
                        }
                    ?>
                </div>
            </form>
            <div class="row">
                <?php
                if($qrSrc == null) {
                    echo '<div class="text-center">เบอร์โทรศัพธ์ที่ลงทะเบียนกับ PromptPay ไม่ถูกต้อง กรุณาแก้ไขโปรไฟล์ของท่าน</div>';
                } else {
                    echo '<div class="text-center"><img id="qr-preview" src="'.$qrSrc.'"></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style>
    .card-body {
        padding: 25px;
    }
</style>
<script>
    function add() {
        window.location.href = "create_account_bank.php";
    }
    function confirmRemove() {
        return confirm('ต้องการลบออกใช่ไหม ?');
    }
</script>
