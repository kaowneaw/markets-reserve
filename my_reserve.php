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
$sql = "SELECT * FROM store_booking WHERE user_id = '$userId'";
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
    <h3 class="card-title text-white">รายการจองของฉัน</h3>

    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        echo '<table class="table table-bordered">';
        echo ' <thead>';
        echo '  <tr>';
        echo '    <th class="text-center col-md-1">ลำดับ</th>';
        echo '    <th class="col-md-2">รหัสการจอง</th>';
        echo '    <th class="col-md-3">วันที่ทำรายการ</th>';
        echo '    <th class="col-md-3">สถานะ</th>';
        echo '    <th class="col-md-3">เครื่องมือ</th>';
        echo '  </tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo '  <tr>';
            echo '    <td class="text-center">' . $count . '</td>';
            echo '    <td>' . $row["store_booking_id"] . '</td>';
            echo '    <td>' . $row["create_date"] . '</td>';
            if($row["status"] === 'WAIT') {
                echo '    <td>รอการชำระเงิน</td>';
            } else {
                echo '    <td>' . $row["status"] . '</td>';
            }
            echo '    <td><button class="btn btn-primary pull-left" onclick="view(' . $row["store_booking_id"] . ')" style="padding: 5px 25px;">ดู</button></td>';
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
        window.location.href = "reserve_detail.php?reserveId=" + id;
    }
</script>
