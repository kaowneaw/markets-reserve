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
if(!isset($_GET['marketId'])) {
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

$year = '2018';
if(isset($_POST['year'])){
    $year = $_POST['year'];
}

$marketId = $_GET['marketId'];
$sql = "SELECT *,MONTH(create_date) as monthNum,SUM(price) as totalPrice FROM store_booking INNER JOIN store_booking_detail ON store_booking.store_booking_id = store_booking_detail.booking_id WHERE YEAR(create_date) = '$year' AND status = 'APPROVE' AND market_id = '$marketId' GROUP BY YEAR(create_date), MONTH(create_date)";
$result = $conn->query($sql);
$data = array();
if ($result->num_rows > 0) {
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    }
}
$data = json_encode($data); //แปลงเป็น json format เอาไปใช้ใน javascript


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
            <h3 class="text-white">รายงานรายได้</h3>
        </div>
        <div class="col-xs-6">
            <h3 class="text-white row">
                <form method="POST" class="pull-right" style="width: 220px">
                    <select class="form-control pull-left" name="year" style="max-width: 120px;margin-right: 15px;">
                        <option <?=$year == '2018' ? ' selected="selected"' : '';?>>2018</option>
                        <option <?=$year == '2017' ? ' selected="selected"' : '';?>>2017</option>
                        <option <?=$year == '2016' ? ' selected="selected"' : '';?>>2016</option>
                        <option <?=$year == '2015' ? ' selected="selected"' : '';?>>2015</option>
                    </select>
                    <button class="btn btn-default pull-left" >ตกลง</button>
                </form>
                <label class="pull-right" style="margin-right: 15px">เลือกปี </label>
            </h3>
        </div>
    </div>
    <div id="chartContainer" class="card">
        <canvas id="myChart"></canvas>
    </div>
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
<script>

    $(document).ready(function () {
        var data = JSON.parse('<?php echo $data; ?>');
        var months = ['มกราคม','กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        var values = [];
        for (var i = 0; i < data.length; i++) {
            // เริ่มต้นที่ 0
            values[parseInt(data[i].monthNum)-1] = data[i].totalPrice;
        }

        var ctx = document.getElementById("myChart").getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'รายได้',
                    data: values
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    });

</script>
