<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start();


if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES["fileImgCover"]) && isset($_FILES["fileImgMap"]) && !empty($_FILES["fileImgCover"])&& !empty($_FILES["fileImgMap"])) {
    // upload img cover
    $extensionImgCover = pathinfo($_FILES["fileImgCover"]["name"], PATHINFO_EXTENSION);
    if (strtolower($extensionImgCover) != "jpg" && strtolower($extensionImgCover) != "jpeg") {
        echo "<script type='text/javascript'>window.alert('รูปหน้าปกตลาด สนับสนุนเฉพาะไฟล์ประเภท JPG และ JPEG');window.location.href='create_market.php';</script>";
        return false;
    }
    $newFilenameCover = round(microtime(true)) . '.' . $extensionImgCover;
    $targetFileCover = "uploads/" . $newFilenameCover;

    if (move_uploaded_file($_FILES["fileImgCover"]["tmp_name"], $targetFileCover)) {

    } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
    }

    // upload img map
    $extensionImgMap = pathinfo($_FILES["fileImgMap"]["name"], PATHINFO_EXTENSION);
    if (strtolower($extensionImgMap) != "jpg" && strtolower($extensionImgMap) != "jpeg") {
        echo "<script type='text/javascript'>window.alert('รูปแผนที่ตลาด สนับสนุนเฉพาะไฟล์ประเภท JPG และ JPEG');window.location.href='create_market.php';</script>";
        return false;
    }

    $newFilenameMap = round(microtime(true)) . '.' . $extensionImgMap;
    $targetFileMap = "uploads/" . $newFilenameMap;

    if (move_uploaded_file($_FILES["fileImgMap"]["tmp_name"], $targetFileMap)) {

    } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
    }

    $name = $_POST['name'];
    $description = $_POST['description'];
    $sql = "INSERT INTO markets (name, userId, map_img, description, create_date) VALUES ('$name', '1', '$targetFileMap', '$description', now());";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; // get last market id insert

        $sql = "INSERT INTO markets_img (img_url, market_id) VALUES ('$targetFileCover', '$last_id');"; // add img markets
        if ($conn->query($sql) === TRUE) {
            header('Location: create_map_market.php?marketId=' . $last_id);
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <h3 class="card-title">สร้างตลาด</h3>
    <form method="POST" enctype="multipart/form-data" id="myform" action="create_market.php">
        <div id="container" class="panel card">
            <div class="card-body">
                <label><i class="fa fa-file-image-o" aria-hidden="true"></i> รูปหน้าปกตลาด</label>
                <div class="img-area-wrapper text-center"><img id="image_preview_cover" alt="IMG PREVIEW"></div>
                <div class="form-group">
                    <input type='file' id="inputFileImgCover" class="form-group" name="fileImgCover"/>
                    <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                        <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
                    </div>
                </div>
                <label><i class="fa fa-map" aria-hidden="true"></i> รูปแผนที่ตลาด</label>
                <div class="form-group">
                    <div class="img-area-wrapper text-center"><img id="image_preview_map" alt="IMG PREVIEW"></div>
                    <div class="form-group">
                        <input type='file' id="inputFileImgMap" class="form-group" name="fileImgMap"/>
                        <div class="alert alert-warning" role="alert" id="alert2" style="display: none">
                            <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>ชื่อตลาด</label>
                    <input type="text" class="form-control" placeholder="ชื่อตลาด" name="name" required
                           autocomplete="off">
                </div>
                <div class="form-group">
                    <label>คำอธิบาย</label>
                    <textarea type="text" class="form-control" placeholder="คำอธิบาย" name="description"></textarea>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">บันทึก</button>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
<style>
    .img-area-wrapper {
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
        max-width: 420px;
    }

    .img-area-wrapper img {
        max-width: 420px;
    }
</style>
<script>

    $(document).ready(function () {
        $("#myform").trigger('reset'); // RESET FORM

        $("#inputFileImgCover").change(function () {
            readURL(this);
        });
        $("#inputFileImgMap").change(function () {
            readURL2(this);
        });
    });

    // for cover market
    function readURL(input) {
        //display img from file
        if (input.files && input.files[0]) {
            if (input.files[0].name.split('.').pop().toUpperCase() !== 'JPG') {
                $("#alert").show();
                return false;
            }
            $("#alert").hide();
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_preview_cover').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // for map market
    function readURL2(input) {
        //display img from file
        if (input.files && input.files[0]) {
            if (input.files[0].name.split('.').pop().toUpperCase() !== 'JPG') {
                $("#alert2").show();
                return false;
            }
            $("#alert2").hide();
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_preview_map').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
