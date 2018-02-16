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
$sql = "SELECT * FROM markets LEFT JOIN markets_img ON markets.markets_id = markets_img.market_id WHERE userId = '$userId'"; //เลือกตลาดของเรา
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
    <div class="row  form-group">
        <div class="col-xs-6">
            <h3 class="text-white">รายงานรายได้แต่ละตลาด</h3>
        </div>
        <div class="col-xs-6">
        </div>
    </div>
    <?php
    if ($result->num_rows > 0) {
        // output data of each row แสดงตาราง
        echo '<table class="table table-bordered">';
        echo ' <thead>';
        echo '  <tr>';
        echo '    <th class="text-center col-md-1">ลำดับ</th>';
        echo '    <th class="col-md-4">ชื่อตลาด</th>';
        echo '    <th class="col-md-1 text-center">เครื่องมือ</th>';
        echo '  </tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo '  <tr>';
            echo '    <td class="text-center">' . $count . '</td>';
            echo '    <td>' . $row["name"] . '</td>';
            echo '    <td class="text-center"><a type="button" class="btn btn-primary" href="report_income_market.php?marketId='.$row["markets_id"].'">ดูรายงาน</a></td>';
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
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
        border-radius: 4px;
        padding: 15px 25px;
    }

</style>
