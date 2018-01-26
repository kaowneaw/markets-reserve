<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
session_start(); // Starting Session

if (!$_SESSION["user"]) {  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

if (isset($_POST['userId']) && isset($_POST['status'])) {
    // update status user
    $userId = $_POST['userId'];
    $status = $_POST['status']; // 0 = ไม่ใช้งาน , 1 = ใช้งาน
    $status = 1 - $status; // สลับ status
    $sql = "UPDATE users SET status = '$status' WHERE users_id = '$userId'";
    if ($conn->query($sql) === TRUE) {
        header('Location: manage_user.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE role = 'USER' ORDER BY users_id DESC"; //เลือกผู้ใช้งาน type user
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
    <div class="row">
        <div class="col-md-12">
            <h3 class="pull-left text-white">รายชื่อผู้ใช้งาน</h3>
        </div>
    </div>

    <?php
    if ($result->num_rows > 0) {
        // output data of each row แสดงตาราง
        echo '<table class="table table-bordered">';
        echo ' <thead>';
        echo '  <tr>';
        echo '    <th class="text-center col-md-1">ลำดับ</th>';
        echo '    <th class="col-md-2">รูปภาพ</th>';
        echo '    <th class="col-md-2">username</th>';
        echo '    <th class="col-md-2">ชื่อ นามสกุล</th>';
        echo '    <th class="col-md-1">โทร</th>';
        echo '    <th class="col-md-1">email</th>';
        echo '    <th class="col-md-3">เครื่องมือ</th>';
        echo '  </tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo '  <tr>';
            echo '    <td class="text-center">' . $count . '</td>';
            echo '    <td class="text-center"><img src="' . $row["img"] . '" class="img-table"/></td>';
            echo '    <td>' . $row["username"] . '</td>';
            echo '    <td>' . $row["first_name"] .' '.$row["last_name"]. '</td>';
            echo '    <td>' . $row["tel"] . '</td>';
            echo '    <td>' . $row["email"] . '</td>';
            echo '    <td>';
            echo '      <button class="btn btn-warning pull-left" onclick="edit(' . $row["users_id"] . ')" style="margin-right: 5px;">แก้ไข</button>';
            echo '      <form method="post">';
            echo '       <input value="' . $row["users_id"] . '" name="userId" class="hide">';
            echo '       <input value="' . $row["status"] . '" name="status" class="hide">';
            if($row["status"] === '1') {
                echo '       <button class="btn btn-danger pull-left" type="submit">ปิดใช้งาน</button>';
            } else {
                echo '       <button class="btn btn-success pull-left" type="submit">เปิดใช้งาน</button>';
            }
            echo '      </form>';
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
    .img-table {
        width: 100%;
        height: 80px;
        object-fit: cover;
    }

    .hide {
        display: none;
    }
    td .btn {
        /*width: 80px;*/
        margin-bottom: 5px;
    }
</style>
<script>

    function edit(id) {
        window.location.href = "edit_user.php?userId=" + id;
    }

</script>