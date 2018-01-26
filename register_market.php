<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');

if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['idcard']) && isset($_POST['username']) && isset($_POST['password'])) {
    // upload img cover
    if (isset($_FILES["fileImg"]) && $_FILES["fileImg"]['error'] == 0) { //มีไฟล์มั้ย
        $extensionImg = pathinfo($_FILES["fileImg"]["name"], PATHINFO_EXTENSION); //เก็บนามสกุลไฟล์
        if (strtolower($extensionImg) != "jpg" && strtolower($extensionImg) != "jpeg") {
            echo "<script type='text/javascript'>window.alert('รูปหน้าปกตลาด สนับสนุนเฉพาะไฟล์ประเภท JPG และ JPEG');window.location.href='register_user.php';</script>";
            return false;
        }
        $newFilename = round(microtime(true)) . '.' . $extensionImg; //สร้างชื่อไฟล์รอ
        $targetFile = "uploads/" . $newFilename;

        if (move_uploaded_file($_FILES["fileImg"]["tmp_name"], $targetFile)) { //เนื้อไฟล์

        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    } else {
        echo "<script type='text/javascript'>window.alert('กรุณาเลือกรูปโปรไฟล์');window.location.href='register_user.php';</script>";
        return false;
    }

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $idcard = $_POST['idcard'];
    $tel = $_POST['tel'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
    $email = $_POST['email'];
    $type = "MARKET";
    $sql = "INSERT INTO users (first_name, last_name, tel, address, email,img,id_card, username, password, type, role, status) VALUES ('$firstname', '$lastname', '$tel', '$address', '$email', '$targetFile','$idcard', '$username', '$password', '$type', 'USER', '1');";
    //user status 1 = เปิดใช้งาน
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
<?php require('./common/nav.php'); ?>
<div class="container">
    <div class="col-md-offset-2 col-md-8 card">
        <h3>สมัครสมาชิก ส่วนของพ่อค้า/แม่ค้า</h3>
        &nbsp;
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label><i class="fa fa-file-image-o" aria-hidden="true"></i> รูปโปรไฟล์</label>
                <div class="img-area-wrapper text-center"><img id="image_preview" alt="IMG PREVIEW"></div>
                <div class="form-group">
                    <input type='file' id="inputFileImg" class="form-group" name="fileImg"/>
                    <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                        <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name">ชื่อ</label>
                <input type="text" id="firstname" name="firstname" class="form-control" placeholder="ชื่อ" required>
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
                <label>Email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label>ที่อยู่</label>
                <textarea type="text" id="address" name="address" class="form-control" placeholder="ที่อยู่"></textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password"id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<style>
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        background-color: white;
        border-radius: 4px;
        padding: 15px 25px;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .img-area-wrapper {
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
        max-width: 260px;
    }

    .img-area-wrapper img {
        max-width: 260px;
    }
</style>
<script>
    $(document).ready(function () {
        $("#myform").trigger('reset'); // RESET FORM

        $("#inputFileImg").change(function () {
            readURL(this);
        });
    });

    function readURL(input) {
        //display img from file
        if (input.files && input.files[0]) {
            if (input.files[0].name.split('.').pop().toUpperCase() !== 'JPG' && input.files[0].name.split('.').pop().toUpperCase() !== 'JPEG') {
                $("#alert").show();
                return false;
            }
            $("#alert").hide();
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
