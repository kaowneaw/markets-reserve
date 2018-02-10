<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');

// Start the session
session_start(); // Starting Session
$hasError = false;
$error = '';

if (!$_SESSION["user"]) {  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

if (!isset($_GET['reserveId'])) {
    header('Location: index.php');
} else {
   $reserveId =  $_GET['reserveId'];
   if(isset($_POST['datetime'])) {
       if (isset($_FILES["fileSlip"]) && $_FILES["fileSlip"]['error'] == 0) { //มีไฟล์มั้ย
           $extensionImg = pathinfo($_FILES["fileSlip"]["name"], PATHINFO_EXTENSION); //เก็บนามสกุลไฟล์
           if (strtolower($extensionImg) != "jpg" && strtolower($extensionImg) != "jpeg" && strtolower($extensionImg) != "png") {
               echo "<script type='text/javascript'>window.alert('ชนิดของไฟล์ไม่สนับสนุน');</script>";
               return false;
           }
           $newFilename = round(microtime(true)) . '.' . $extensionImg; //สร้างชื่อไฟล์รอ
           $targetFile = "uploads/" . $newFilename;

           if (move_uploaded_file($_FILES["fileSlip"]["tmp_name"], $targetFile)) { //เนื้อไฟล์

           } else {
               echo "Sorry, there was an error uploading your file.";
               return false;
           }
       } else {
           echo "<script type='text/javascript'>window.alert('กรุณาเลือกแนบรูปถ่ายสลิป');</script>";
           return false;
       }

       $datetime = $_POST['datetime'];
       $account_bank_to = $_POST['account_bank_to'];
       $account_bank_from = $_POST['account_bank_from'];
       $userId = $_SESSION["user"]->users_id;

       $sql = "INSERT INTO report_transfer (date_time, bank_account_from, bank_account_to, booking_id, attachment) VALUES ('$datetime', '$account_bank_from', '$account_bank_to', '$reserveId', '$targetFile')";
       if ($conn->query($sql) === TRUE) {
           $sql = "UPDATE store_booking SET status = 'REPORTED' WHERE store_booking_id = ".$reserveId; // update สถานะ เป็นแจ้งโอนแล้ว
           if ($conn->query($sql) === TRUE) {
               header('Location: my_reserve.php'); // redirect to page
           } else {
               $hasError = true;
               $error = $conn->error;
           }
        } else {
           $hasError = true;
           $error = $conn->error;
       }
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
    <div class="col-md-offset-3 col-md-6 card">
        <h3>แจ้งโอนเงิน</h3>
        &nbsp;
        <form method="POST" enctype="multipart/form-data" >
            <div class="form-group">
                <label><i class="fa fa-file-image-o" aria-hidden="true"></i> แนบรูปถ่ายสลิป</label>
                <div class="form-group">
                    <input type='file' id="inputFileImg" class="form-group" name="fileSlip"/>
                    <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                        <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="dtp_input2" class="control-label">วัน-เวลาที่ทำรายการโอนเงิน <i class="fa fa-calendar" aria-hidden="true"></i></label>
                    <div class="input-append date form_datetime">
                        <input id="datetime" size="16" type="text" value="" name="datetime" readonly class="form-control" required>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="dtp_input2" class="control-label">โอนจากธนาคาร</label>
                <select type="text" id="account_bank" name="account_bank_from" class="form-control" required>
                    <option>ธนาคารกรุงเทพ</option>
                    <option>ธนาคารกสิกรไทย</option>
                    <option>ธนาคารกรุงไทย</option>
                    <option>ธนาคารทหารไทย</option>
                    <option>ธนาคารไทยพาณิชย์</option>
                    <option>ธนาคารกรุงศรีอยุธยา</option>
                    <option>ธนาคารเกียรตินาคิน</option>
                    <option>ธนาคารซีไอเอ็มบีไทย</option>
                    <option>ธนาคารทิสโก้</option>
                    <option>ธนาคารธนชาต</option>
                    <option>ธนาคารยูโอบี</option>
                    <option>ธนาคารออมสิน</option>
                    <option>ธนาคารอาคารสงเคราะห์</option>
                    <option>ธนาคารอิสลามแห่งประเทศไทย</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dtp_input2" class="control-label">โอนเข้าบัญชีธนาคาร</label>
                <select type="text" id="account_bank" name="account_bank_to" class="form-control" required>
                    <option>ธนาคารกรุงเทพ</option>
                    <option>ธนาคารกสิกรไทย</option>
                    <option>ธนาคารกรุงไทย</option>
                    <option>ธนาคารทหารไทย</option>
                    <option>ธนาคารไทยพาณิชย์</option>
                    <option>ธนาคารกรุงศรีอยุธยา</option>
                    <option>ธนาคารเกียรตินาคิน</option>
                    <option>ธนาคารซีไอเอ็มบีไทย</option>
                    <option>ธนาคารทิสโก้</option>
                    <option>ธนาคารธนชาต</option>
                    <option>ธนาคารยูโอบี</option>
                    <option>ธนาคารออมสิน</option>
                    <option>ธนาคารอาคารสงเคราะห์</option>
                    <option>ธนาคารอิสลามแห่งประเทศไทย</option>
                </select>
            </div>
            <div class="form-group text-right">
                <?php  if($hasError) echo '<span class="text-danger">'.$error.'</span>' ?>
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<style>
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        background-color: white;
        border-radius: 4px;
        padding: 15px 25px;
    }

</style>
<script>

    $(document).ready(function () {
        $(".form_datetime").datetimepicker();
        $('#datetime').val(formatDate(new Date()));
    });

    function formatDate(date) {
        var day = date.getDate();
        var month = date.getMonth()+1;
        var year = date.getFullYear();
        var hh = date.getHours();
        var minute = date.getMinutes();

        if (month < 10) {
            month = '0' + month;
        }
        if (day < 10) {
            day = '0' + day;
        }
        if (hh < 10) {
            hh = '0' + hh;
        }
        if (minute < 10) {
            minute = '0' + minute;
        }

        return year+'-'+month+'-'+day+' '+hh+':'+minute;
    }

</script>
