<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('header.php');
require('db_connect.php');
if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['idcard']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type'])) {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $tel = $_POST['idcard'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $type = $_POST['type'];
    $sql = "INSERT INTO users (first_name, last_name, tel, username, password, type, role) VALUES ('$name', '$lastname', '$tel', '$username', '$password', '$type', 'USER');";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header('Location: login.php'); // redirect to register page
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Markets</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="add_market.php">Home <span class="sr-only">(current)</span></a>
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
    <div class="offset-md-2 col-md-8">
        <h3>สมัครสมาชิก</h3>
        &nbsp;
        <form method="POST">
            <div class="form-group">
                <label for="name">ชื่อ</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อ" required>
            </div>
            <div class="form-group">
                <label for="lastname">นามสกุล</label>
                <input type="text" id="lastname" name="lastname" class="form-control" placeholder="นามสกุล" required>
            </div>
            <div class="form-group">
                <label>เบอร์โทรศัพท์</label>
                <input type="text" id="tel" name="tel" class="form-control" placeholder="เบอร์โทรศัพท์" required>
            </div>
            <div class="form-group">
                <label>เลขบัตรประชาชน</label>
                <input type="text" id="idcard" name="idcard" class="form-control" placeholder="เลขบัตรประชาชน" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password"id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="type">
                    <option selected value="MERCHANT">พ่อค้า / แม่ค้า</option>
                    <option value="MARKET">เจ้าของตลาด</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary float-right">ยืนยัน</button>
        </form>
    </div>
</div>
</body>
</html>
