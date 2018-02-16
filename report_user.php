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
    $sql = "SELECT COUNT(type) as amount,type FROM users GROUP BY type ORDER BY type DESC";
    $result = $conn->query($sql);
    $roles = array();
    if ($result->num_rows > 0) {
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                array_push($roles, $row);
            }
        }
    }
    $roles = json_encode($roles); //แปลงเป็น json format เอาไปใช้ใน javascript
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
            <h3 class="text-white">รายงานผู้ใช้งาน</h3>
        </div>
        <div class="col-xs-6">
            <h3 class="text-white text-right">จำนวนผู้ใช้งานทั้งหมด <span id="total"></span> คน</h3>
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
        var roles = JSON.parse('<?php echo $roles; ?>');
        var rolesName = [];
        var rolesValue = [];
        var total = 0;
        for (var i = 0; i < roles.length; i++) {
            rolesName.push(roles[i].type);
            rolesValue.push(roles[i].amount);
            total += parseInt(roles[i].amount);
        }
        console.log(total);
        $("#total").html(total);

        var ctx = document.getElementById("myChart").getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rolesName,
                datasets: [{
                    label: 'ข้อมูลผู้ใช้งาน',
                    data: rolesValue,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
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
