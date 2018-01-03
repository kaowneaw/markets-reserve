<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
session_start(); // Starting Session
$show_err_msg = false;

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' limit 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($obj = mysqli_fetch_object($result)) {
            $_SESSION['user'] = $obj;
        }
        header('Location: my_market.php'); // redirect to home page
        exit(0);
    } else {
        $show_err_msg = true; //ไว้ check show alert message
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
    <div class="login card">
        <form method="POST">
            <div class="form-group text-center">
                <img src="./img/online-store.png" width="100px"/>
            </div>
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้งาน</label>
                <input type="text" name="username" placeholder="ชื่อผู้ใช้งาน" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="Password">รหัสผ่าน</label>
                <input type="password" name="password" placeholder="รหัสผ่าน" class="form-control">
            </div>
            <div class="text-right">
                <button class="btn btn-primary" type="submit">ตกลง</button>
            </div>
        </form>
        <?php
        if ($show_err_msg == true) {
            echo '<div class="alert alert-warning" role="alert">Username หรือ Password ไม่ถูกต้อง</div>';
        }
        ?>
    </div>
</div>
</body>
</html>
<style>
    .login {
        max-width: 520px;
        padding: 35px 35px 15px 35px;
        margin-top: 10%;
        margin-left: auto;
        margin-right: auto;
        background-color: white;
        border-radius: 4px;
    }
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

</style>
<script>
    $(document).ready(function () {
        $(".alert").alert();
    });
</script>