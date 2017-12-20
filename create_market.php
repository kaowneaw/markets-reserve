<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES["fileImgUpload"])) {
        $extension = pathinfo($_FILES["fileImgUpload"]["name"], PATHINFO_EXTENSION);
        if (strtolower($extension) != "jpg") {
            echo "<script type='text/javascript'>window.alert('Sorry, only JPG are allowed.');window.location.href='create_market.php';</script>";
            return false;
        }

        $newFilename = round(microtime(true)) . '.' . $extension;
        $target_file = "uploads/" . $newFilename;

        if (move_uploaded_file($_FILES["fileImgUpload"]["tmp_name"], $target_file)) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $sql = "INSERT INTO markets (name, userId, description) VALUES ('$name', '1', '$description');";
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id; // get last market id insert

                $sql = "INSERT INTO markets_img (img_url, market_id) VALUES ('$target_file', '$last_id');"; // add img markets
                if ($conn->query($sql) === TRUE) {
                    header('Location: create_map_market.php?marketId=' . $last_id);
                    exit(0);
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
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
    <form method="POST" enctype="multipart/form-data">
        <div id="container" class="panel card">
            <div class="card-body">
                <label>รูปภาพตลาด</label>
                <div class="img-area-wrapper text-center"><img id="image_upload_preview" alt="IMG PREVIEW"></div>
                <div class="form-group">
                    <input type='file' id="inputFile" class="form-group" name="fileImgUpload"/>
                    <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                        <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
                    </div>
                </div>
                <div class="form-group">
                    <label>ชื่อตลาด</label>
                    <input type="text" class="form-control" placeholder="ชื่อตลาด" name="name" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>คำอธิบาย</label>
                    <textarea type="text" class="form-control" placeholder="คำอธิบาย" name="description"></textarea>
                </div>
                <div class="text-right"><button class="btn btn-primary" type="submit">บันทึก</button></div>
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
        width: 420px;
    }
    .img-area-wrapper img {
        max-width: 420px;
    }
</style>
<script>

    $(document).ready(function () {
        $("#inputFile").change(function () {
            readURL(this);
        });
    });

    function readURL(input) {
        //display img from file
        if (input.files && input.files[0]) {
            if (input.files[0].name.split('.').pop().toUpperCase() !== 'JPG') {
                $("#alert").show();
                typeFile = false;
                return false;
            }
            $("#alert").hide();
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
