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

if (!isset($_GET['reserveId'])) {
    header('Location: index.php');
} else {

    $reserveId = $_GET['reserveId'];// reserveId = store_booking_id
    $sql = "SELECT * FROM (SELECT markets.markets_id,markets.userId,deposit,store_market_id,store_name,type_id,market_type_name,markets.name FROM market_store ms INNER JOIN markets_type mt ON ms.type_id = mt.markets_type_id INNER JOIN markets ON markets.markets_id = ms.markets_id ) store  
     INNER JOIN ( SELECT * FROM store_booking sb INNER JOIN store_booking_detail sbd ON sb.store_booking_id = sbd.booking_id WHERE store_booking_id = '$reserveId' ) booking ON store.store_market_id = booking.store_id INNER JOIN users on users.users_id = store.userId";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $reserveData = $row;
        }
    } else {
        echo "No Results";
    }
}

if($reserveData['isUsePromtPay'] == '1') {
    // generate prompt pay qr code
    $PromptPayQR = new PromptPayQR(); // new object
    $PromptPayQR->size = 8; // Set QR code size to 8
    $PromptPayQR->id = $reserveData['tel']; // PromptPay ID
    $PromptPayQR->amount = 1;
    $qrSrc = $PromptPayQR->generate();
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
            <h3 class="pull-right text-white">ช่องทางการชำระเงิน</h3>
        </div>
    </div>
    <div id="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="row form-group">
                        <div class="card-body">
                            <div class="col-xs-12">
                                <label class="control-label form-group">จำนวนเงินที่ต้องชำระ</label>
                                <br>
                                <?php  echo '    <label class="control-label">ประเภท '.$reserveData['market_type_name'].'</label>'; ?>
                            </div>
                            <?php
                            if($reserveData['type_id'] != '1') {
                                echo '<div class="col-xs-4">';
                                echo '    <h3><label class="control-label">ค่ามัดจำ</label></h3>';
                                echo '</div>';
                                echo '<div class="col-xs-8">';
                                echo '    <h3><label class="control-label">'. $reserveData['deposit'] . ' บาท</label></h3>';
                                echo '</div>';
                            } else {
                                echo '<div class="col-xs-4">';
                                echo '    <h3><label class="control-label">ค่าเช่า</label></h3>';
                                echo '</div>';
                                echo '<div class="col-xs-8">';
                                echo '    <h3><label class="control-label">'. $reserveData['price'] . ' บาท</label></h3>';
                                echo '</div>';
                            }
                            ?>
                            <div class="col-xs-12 text-right"><a  href="report_transfer.php?reserveId=<?php echo $reserveId?>" class="btn btn-success">แจ้งโอนเงิน</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel">
                    <?php
                    if(isset($qrSrc)) { //QR CODE PromtPay
                        echo '<div class="card-body"><h4>โอนเงินผ่าน PromtPay</h4></div>';
                        echo '<div class="text-center"><img id="qr-preview" src="'.$qrSrc.'"></div>';
                    }
                    $sql = "SELECT * FROM payment_info WHERE user_id  = ". $reserveData['userId']; // userId เจ้าของตลาด
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<div class="card-body" style="padding-bottom: 10px"><h4>โอนเงินผ่านบัญชีธนาคาร</h4></div>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="panel card" style="border-bottom: 1px solid black;">';
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
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
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
