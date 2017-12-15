<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('header.php');
require('db_connect.php');
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
        header('Location: home.php'); // redirect to home page
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Markets</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="panel login card">
        <form method="POST">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้งาน</label>
                <input type="text" name="username" placeholder="ชื่อผู้ใช้งาน" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="Password">รหัสผ่าน</label>
                <input type="password" name="password" placeholder="รหัสผ่าน" class="form-control">
            </div>
            <div class="text-right">
                <button class="btn btn-dark" type="submit">ตกลง</button>
            </div>
        </form>
        <?php
        if ($show_err_msg == true) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">' .
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
                '    <span aria-hidden="true">&times;</span>' .
                '  </button> Username หรือ Password ไม่ถูกต้อง ' .
                '</div>';
        }
        ?>
    </div>
</div>
</body>
</html>
<style>
    .login {
        max-width: 520px;
        padding: 15px 15px 0px 15px;
        margin-top: 20%;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<script>
    $(document).ready(function () {
        $(".alert").alert();
    });
</script>