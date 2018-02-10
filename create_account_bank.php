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

if (isset($_POST['account_name']) && isset($_POST['account_id']) && isset($_POST['account_bank'])) {

    if($_POST['account_bank'] == 'null') { // check ว่า user เลือกธนาคารหรือป่าว
        $hasError = true;
        $error = 'กรุณาเลือกธนาคาร';
    } else {
        $account_name= $_POST['account_name'];
        $account_id = $_POST['account_id'];
        $account_bank = $_POST['account_bank'];
        $userId = $_SESSION["user"]->users_id;
        $status= $_POST['status'];
        $sql = "INSERT INTO payment_info (account_name, account_id, account_bank, user_id,status) VALUES ('$account_name', '$account_id', '$account_bank', '$userId','$status');";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header('Location: my_account_bank.php'); // redirect to my_account_bank page
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
    <div class="col-md-offset-2 col-md-8 card">
        <h3>เพิ่มบัญชีธนาคาร</h3>
        &nbsp;
        <form method="POST">
            <div class="form-group">
                <label for="name">ชื่อบัญชี</label>
                <input type="text" id="account_name" name="account_name" class="form-control" placeholder="ชื่อบัญชี" required>
            </div>
            <div class="form-group">
                <label for="lastname">เลขที่บัญชี</label>
                <input type="text" id="account_id" name="account_id" class="form-control" placeholder="เลขที่บัญชี" required>
            </div>

            <div class="form-group">
                <label>ธนาคาร</label>
                <select type="text" id="account_bank" name="account_bank" class="form-control" placeholder="ธนาคาร" required>
                    <option value="null">เลือกธนาคาร</option>
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
                <label for="status">สถานะ</label>
                <input type="text"  name="status" class="form-control" placeholder="สถานะ" required>
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

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .img-area-wrapper {
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
        max-width: 260px;
    }

    .img-area-wrapper img {
        max-width: 260px;
    }
</style>
<script>

</script>
