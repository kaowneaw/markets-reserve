<?php
require('header.php');
require('db_connect.php');
session_start(); // Starting Session
$show_err_msg = false;

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' limit 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($obj = mysqli_fetch_object($result)) {
            $_SESSION['user'] = $obj;
        }
        header("location: home.php"); // redirect to home page
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
<div class="ui container">
    <div class="ui centered segment login">
        <form class="ui form" method="post" name="login" action="">
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="text-right">
                <button class="ui button" type="submit">ตกลง</button>
            </div>
        </form>
        <?php
        if ($show_err_msg == true) {
            echo '<div class="ui negative message" style="margin-top: 25px">' .
                '<i class="close icon"></i>' .
                '<p style="margin: 0;">username หรือ password ไม่ถูกต้อง</p>' .
                '</div>';
        }
        ?>
    </div>
</div>
</body>
</html>
<style>
    .login {
        margin-top: 30% !important;
        max-width: 490px;
        margin-left: auto !important;
        margin-right: auto !important;
    }
</style>
<script>
    $('.message .close')
        .on('click', function () {
            $(this)
                .closest('.message').hide();
        });
</script>