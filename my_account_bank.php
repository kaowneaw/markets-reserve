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

    $PromptPayQR = new PromptPayQR(); // new object
    $PromptPayQR->size = 8; // Set QR code size to 8
    $PromptPayQR->id = '0841079779'; // PromptPay ID
    $PromptPayQR->amount = 200.25; // Set amount (not necessary)
//  echo '<img src="' . $PromptPayQR->generate() . '" />';

    $userId = $_SESSION['user']->users_id;
    $sql = "SELECT * FROM payment_info WHERE user_id  = ".$userId;
    $result = $conn->query($sql);


if (isset($_POST['payment_id'])) {
    // remove my market ลบตลาด
    $payment_id = $_POST['payment_id'];
    $sql = "DELETE FROM payment_info WHERE payment_id = '$payment_id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: my_account_bank.php');
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
            <h3 class="pull-right">
                <button class="btn btn-success " onclick="add()">เพิ่มบัญชีธนาคาร</button>
            </h3>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li><a href="my_account_bank_promtpay.php">Promptpay QR Code</a></li>
        <li class="active"><a href="my_account_bank.php">รายการบัญชีธนาคาร</a></li>
    </ul>
    <div id="container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="panel card">';
                    echo '    <div class="card-body">';
                    echo '        <div class="row form-group">';
                    echo '            <div class="col-xs-4">';
                    echo '                <label class="control-label">ชื่อบัญชี</label>';
                    echo '            </div>';
                    echo '            <div class="col-xs-8">';
                    echo '                <label class="control-label">' . $row['account_name'] . '</label>';
                    echo '            </div>';
                    echo '    </div>';
                    echo '    <div class="row form-group">';
                    echo '            <div class="col-xs-4">';
                    echo '                <label class="control-label">เลขที่บัญชี</label>';
                    echo '            </div>';
                    echo '            <div class="col-xs-8">';
                    echo '                <label class="control-label">' . $row['account_id'] . '</label>';
                    echo '            </div>';
                    echo '    </div>';
                    echo '    <div class="row">';
                    echo '            <div class="col-xs-4">';
                    echo '                <label class="control-label">ธนาคาร</label>';
                    echo '            </div>';
                    echo '            <div class="col-xs-8">';
                    echo '                <label class="control-label">' . $row['account_bank'] . '</label>';
                    echo '            </div>';
                    echo '            </div>';
                    echo '    </div>';
                    echo '    <div class="row form-group text-right">';
                    echo '      <div class="col-xs-12">';
                    echo '        <form method="post" onsubmit="return confirmRemove(this);">';
                    echo '          <input value="' . $row["payment_id"] . '" name="payment_id" class="hide">';
                    echo '          <button class="btn btn-danger pull-right" style="margin-right: 15px;" type="submit">ลบ</button>';
                    echo '        </form>';
                    echo '      </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            ?>
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
