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

$userId = $_SESSION["user"]->users_id;
$sql = "SELECT * FROM report_transfer rt INNER JOIN store_booking sb ON rt.booking_id = sb.store_booking_id INNER JOIN users ON users.users_id = sb.user_id WHERE sb.status = 'REPORTED'";
$result = $conn->query($sql);

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
    <ul class="nav nav-tabs">
        <li class="active"><a href="notify_transfer_list.php">รายการแจ้งโอนเงิน</a></li>
        <li><a href="notify_transfer_list_history.php">ประวัติรายการชำระเงิน</a></li>
    </ul>
    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        echo '<table class="table table-bordered">';
        echo ' <thead>';
        echo '  <tr>';
        echo '    <th class="text-center col-md-1">รหัสการจอง</th>';
        echo '    <th class="col-md-2">โอนจากธนาคาร</th>';
        echo '    <th class="col-md-2">โอนเข้าบัญชีธนาคาร</th>';
        echo '    <th class="col-md-2">ชื่อผู้โอน</th>';
        echo '    <th class="col-md-3">วัน-เวลาที่ทำรายการโอนเงิน</th>';
        echo '    <th class="col-md-3">เครื่องมือ</th>';
        echo '  </tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo '  <tr>';
            echo '    <td class="text-center">' . $row["store_booking_id"] . '</td>';
            echo '    <td>' . $row["bank_account_from"] . '</td>';
            echo '    <td>' . $row["bank_account_to"] . '</td>';
            echo '    <td>' . $row["first_name"].' '.$row["last_name"]. '</td>';
            echo '    <td>' . $row["date_time"] . '</td>';
            echo '    <td><button class="btn btn-primary pull-left" onclick="view(' . $row["booking_id"] . ')" style="padding: 5px 25px;">ดู</button></td>';
            echo '  </tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<h4 class="text-center text-white"> 0 results</h4>';
    }
    ?>

</div>
</body>
</html>
<style>
</style>
<script>
    function view(id) {
        window.location.href = "notify_transfer_list_detail.php?reserveId=" + id;
    }
</script>
