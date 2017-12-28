<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');

if(isset($_POST['marketId'])) {
    // remove my market
    $marketId = $_POST['marketId'];
    $sql = "DELETE FROM markets WHERE markets_id = '$marketId'";
    if ($conn->query($sql) === TRUE) {
        header('Location: my_market.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$userId = '1';
$sql = "SELECT * FROM markets LEFT JOIN markets_img ON markets.markets_id = markets_img.market_id WHERE userId = '$userId'";
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
    <div class="header-title"><h3 class="pull-left">รายชื่อตลาด</h3> <button class="btn btn-success pull-right" onclick="addmarket()">เพิ่มตลาด</button></div>

    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        echo '<div class="row form-group">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-6">';
            echo '    <div class="card">';
            echo '        <div class="card-container">';
            echo '        <a href="create_map_market.php?marketId='.$row["markets_id"].'">';
            echo '            <div class="form-group"><small>ชื่อตลาด</small><small class="pull-right">'.$row["create_date"].'</small></div>';
            echo '            <h5>' . $row["name"] . '</h5>';
            echo '            <div class="container-img"><img src="' . $row["img_url"] . '" class="market-img" /></div>';
            echo '            <small class="form-group">รายละเอียด</small>';
            echo '            <p>'.$row["description"].'</p>';
            echo '        </a>';
            echo '        <div>';
            echo '               <button class="btn btn-primary pull-right">แก้ไข</button>';
            echo '               <form method="post" class="pull-right" style="margin-right: 5px;" onsubmit="return confirmRemove(this);">';
            echo '                  <input value="'.$row["markets_id"].'" name="marketId" class="hide">';
            echo '                  <button class="btn btn-danger" type="submit">ลบ</button>';
            echo '               </form>';
            echo '         </div>';
            echo '       </div>';
            echo '    </div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "0 results";
    }
    ?>

</div>
</body>
</html>
<style>
    .header-title{
        overflow: hidden;
    }
    .card-container {
        padding: 15px;
    }
    a {
        color: black !important;
    }
    a:hover {
        color: black !important;
        text-decoration: none !important;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        margin: 10px;
    }
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .container-img {
        width: 220px;
        height: 220px;
        margin: 0 auto;
    }

    .container-img img {
        width: 100%;
    }
    .hide {
        display: none;
    }
</style>
<script>

    function confirmRemove() {

        return confirm('ต้องการลบตลาดนี้ออกใช่ไหม ?');
    }

    function addmarket() {
        window.location.href = "create_market.php";
    }
</script>