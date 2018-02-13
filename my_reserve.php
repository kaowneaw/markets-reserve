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
$sql = "SELECT *,store_booking.create_date as booking_created FROM store_booking INNER JOIN markets ON markets.markets_id = store_booking.market_id  WHERE user_id = '$userId' ORDER BY store_booking.store_booking_id DESC";
$result = $conn->query($sql);


if(isset($_POST['store_booking_id'])) {
    $bookingId = $_POST['store_booking_id'];
    $sql = "UPDATE store_booking SET status = 'CANCEL' WHERE store_booking_id = ".$bookingId; // update สถานะ เป็นยกเลิก
    if ($conn->query($sql) === TRUE) {
        header('Location: my_reserve.php'); // redirect to page
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
    <h3 class="card-title text-white">รายการจองของฉัน</h3>

    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        echo '<table class="table table-bordered">';
        echo ' <thead>';
        echo '  <tr>';
        echo '    <th class="text-center col-md-1">ลำดับ</th>';
        echo '    <th class="col-md-1">รหัสการจอง</th>';
        echo '    <th class="col-md-2">ชื่อตลาด</th>';
        echo '    <th class="col-md-3">วันที่ทำรายการ</th>';
        echo '    <th class="col-md-2">สถานะ</th>';
        echo '    <th class="col-md-2">เครื่องมือ</th>';
        echo '  </tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo '  <tr>';
            echo '    <td class="text-center">' . $count . '</td>';
            echo '    <td>' . $row["store_booking_id"] . '</td>';
            echo '    <td>' . $row["name"] . '</td>';
            echo '    <td>' . $row["booking_created"] . '</td>';
            if($row["status"] === 'WAIT') {
                echo '    <td class="text-warning">รอการชำระเงิน</td>';
            } else  if($row["status"] === 'REPORTED') {
                echo '    <td>แจ้งโอนเงินแล้ว</td>';
            } else if($row["status"] === 'APPROVE'){
                echo '    <td class="text-success">ชำระเงินแล้ว</td>';
            }else if($row["status"] === 'CANCEL'){
                echo '    <td class="text-danger">ยกเลิกการจอง</td>';
            } else {
                echo '    <td>'.$row["status"].'</td>';
            }
            echo '    <td>';
            echo '      <button class="btn btn-primary pull-left" onclick="view(' . $row["store_booking_id"] . ')" style="padding: 5px 25px;margin-right: 5px;">ดู</button>';
            if($row["status"] === 'WAIT') {
                echo '      <form method="post" onsubmit="return confirmRemove(this);">';
                echo '       <input value="' . $row["store_booking_id"] . '" name="store_booking_id" class="hide">';
                echo '       <button type="submit" class="btn btn-default pull-left" style="padding: 5px 25px;">ยกเลิก</button>';
                echo '      </form>';
            }
            echo '    </td>';
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
    function confirmRemove() {
        return confirm('ต้องการยกเลิกการจองใช่ไหม ?');
    }

    function view(id) {
        window.location.href = "reserve_detail.php?reserveId=" + id;
    }
</script>
