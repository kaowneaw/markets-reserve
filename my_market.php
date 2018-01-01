<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
session_start(); // Starting Session

if (!$_SESSION["user"]){  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

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
$userId = $_SESSION["user"]->users_id;
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
    <div class="row"><h3 class="pull-left">รายชื่อตลาด</h3> <h3 class="pull-right"><button class="btn btn-success " onclick="add()">สร้างตลาด</button></h3></div>

    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        echo '<table class="table table-bordered">';
        echo ' <thead>';
        echo '  <tr>';
        echo '    <th class="text-center col-md-1">#</th>';
        echo '    <th class="col-md-2">รูปภาพ</th>';
        echo '    <th class="col-md-3">ชื่อตลาด</th>';
        echo '    <th class="col-md-3">รายละเอียด</th>';
        echo '    <th class="col-md-2">เครื่องมือ</th>';
        echo '  </tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo '  <tr>';
            echo '    <td class="text-center">'.$count.'</td>';
            echo '    <td class="text-center"><img src="' . $row["img_url"] . '" class="img-preview"/></td>';
            echo '    <td>' . $row["name"] . '</td>';
            echo '    <td>'.$row["description"].'</td>';
            echo '    <td>';
            echo '      <button class="btn btn-primary pull-left" onclick="view(' . $row["markets_id"] . ')" style="margin-right: 5px;">แผนที่</button>';
            echo '      <button class="btn btn-warning pull-left" onclick="edit(' . $row["markets_id"] . ')" style="margin-right: 5px;">แก้ไข</button>';
            echo '      <form method="post" onsubmit="return confirmRemove(this);">';
            echo '       <input value="'.$row["markets_id"].'" name="marketId" class="hide">';
            echo '       <button class="btn btn-danger pull-left" type="submit">ลบ</button>';
            echo '      </form>';
            echo '    </td>';
            echo '  </tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<h4 class="text-center"> 0 results</h4>';
    }
    ?>

</div>
</body>
</html>
<style>
    .img-preview {
        max-width: 150px;
    }
    .hide {
        display: none;
    }
</style>
<script>

    function confirmRemove() {
        return confirm('ต้องการลบตลาดนี้ออกใช่ไหม ?');
    }

    function add() {
        window.location.href = "create_market.php";
    }

    function edit(id) {
        window.location.href = "edit_market.php?marketId=" + id;
    }

    function view(id) {
        window.location.href = "create_map_market.php?marketId=" + id;
    }
</script>