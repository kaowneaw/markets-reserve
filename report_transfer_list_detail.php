<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start(); // Starting Session

if (!$_SESSION["user"]) {  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}
if (!isset($_GET['reserveId'])) {
    header('Location: index.php');
} else {

    $reserveId = $_GET['reserveId'];
    $sql = "SELECT * FROM (SELECT deposit,store_market_id,store_name,type_id,market_type_name,width,height,markets.name FROM market_store ms INNER JOIN markets_type mt ON ms.type_id = mt.markets_type_id INNER JOIN markets ON markets.markets_id = ms.markets_id ) store  
    INNER JOIN ( SELECT * FROM store_booking sb INNER JOIN store_booking_detail sbd ON sb.store_booking_id = sbd.booking_id  WHERE store_booking_id = '$reserveId' ) booking ON store.store_market_id = booking.store_id";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $reserve = $row; // ข้อมูลการจอง
        }
    } else {
        echo "No Results";
    }

    $sql = "SELECT * FROM report_transfer WHERE booking_id = '$reserveId'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $reportData = $row; // ข้อมูลแจ้งโอนเงิน
        }
    } else {
        echo "No Results";
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
    <h3 class="card-title text-white form-group">รายละเอียดการแจ้งโอนเงิน</h3>
    <div id="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    &nbsp;
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ชื่อ</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['store_name'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วันที่เริ่มต้น</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['start_date'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วันที่สิ้นสุด</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['end_date'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ชื่อตลาด</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['name'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ประเภท</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['market_type_name'] ?></label>
                        </div>
                    </div>
                    <?php
                    if ($reserve['type_id'] != 1) {
                        echo '<div class="row form-group">';
                        echo '   <div class="col-xs-4">';
                        echo '    <label class="control-label">ชำระเงินมัดจำ</label>';
                        echo '   </div>';
                        echo '    <div class="col-xs-8">';
                        echo '      <label class="control-label">'.$reserve['deposit'] .' บาท</label>';
                        echo '    </div>';
                        echo '</div>';
                    }
                    ?>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ค่าเช่า</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['price'] . ' บาท' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ค่าน้ำ/หน่วย</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['water_price_per_unit'] . ' บาท' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ค่าไฟ/หน่วย</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['eletric_price_per_unit'] . ' บาท' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ความกว้าง</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['width'] . ' เมตร' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ความยาว</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['height'] . ' เมตร' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">สถานะ</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label">
                                <?php
                                if($reserve["status"] === 'WAIT') {
                                    echo 'รอการชำระเงิน';
                                } else if($reserve["status"] === 'REPORTED') {
                                    echo 'แจ้งโอนเงินแล้ว';
                                } else {
                                    echo $reserve['status'];
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วันที่ทำรายการ</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['create_date'] ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col1 -->
            <div class="col-md-6">
                <div class="panel">
                    <div class="text-right">
                        <button class="btn btn-success">ยืนยันการชำระเงิน</button>
                    </div>
                    &nbsp;
                    <div class="row form-group">
                        <div class="col-xs-12">
                            <img class="img-responsive" src="<?php echo $reportData['attachment'] ?>" style="margin: 0 auto;"/>
                        </div>
                    </div>
                    &nbsp;
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">โอนจากธนาคาร</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reportData['bank_account_from'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">โอนเข้าบัญชีธนาคาร</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reportData['bank_account_to'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วัน-เวลาที่ทำรายการโอนเงิน</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reportData['date_time'] ?></label>
                        </div>
                    </div>
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
    .panel {
        padding: 25px;
    }
</style>
<script>

</script>
