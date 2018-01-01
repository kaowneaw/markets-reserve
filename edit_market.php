<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start(); // Starting Session

if (!$_SESSION["user"]){  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

if (!isset($_GET['marketId'])) {
    header('Location: my_market.php');
} else {
    $marketId = $_GET['marketId'];
    $sql = "SELECT * FROM markets LEFT JOIN markets_img ON markets.markets_id = markets_img.market_id WHERE markets_id = '$marketId' limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $myMarket = "";
        while ($row = $result->fetch_assoc()) {
            $myMarket = $row; // map
        }
    } else {
        echo "0 results";
    }
}

if (isset($_POST['name']) && isset($_POST['description'])) {

    $targetFileCover = null;
    if (isset($_FILES["fileImgCover"]) && $_FILES["fileImgCover"]['error'] == 0) {
        // upload img cover
        $extensionImgCover = pathinfo($_FILES["fileImgCover"]["name"], PATHINFO_EXTENSION);
        if (strtolower($extensionImgCover) != "jpg" && strtolower($extensionImgCover) != "jpeg") {
            echo "<script type='text/javascript'>window.alert('รูปหน้าปกตลาด สนับสนุนเฉพาะไฟล์ประเภท JPG และ JPEG');location.reload();</script>";
            return false;
        }
        $newFilenameCover = round(microtime(true)) . '.' . $extensionImgCover;
        $targetFileCover = "uploads/" . $newFilenameCover;

        if (move_uploaded_file($_FILES["fileImgCover"]["tmp_name"], $targetFileCover)) {

        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
    $targetFileMap = null;
    if (isset($_FILES["fileImgMap"]) && $_FILES["fileImgMap"]['error'] == 0) {
        // upload img map
        $extensionImgMap = pathinfo($_FILES["fileImgMap"]["name"], PATHINFO_EXTENSION);
        if (strtolower($extensionImgMap) != "jpg" && strtolower($extensionImgMap) != "jpeg") {
            echo "<script type='text/javascript'>window.alert('รูปแผนที่ตลาด สนับสนุนเฉพาะไฟล์ประเภท JPG และ JPEG');location.reload();</script>";
            return false;
        }

        $newFilenameMap = round(microtime(true)) . 'map.' . $extensionImgMap;
        $targetFileMap = "uploads/" . $newFilenameMap;

        if (move_uploaded_file($_FILES["fileImgMap"]["tmp_name"], $targetFileMap)) {

        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }

    $name = $_POST['name'];
    $description = $_POST['description'];
    if ($targetFileMap == null) {
        $sql = "UPDATE markets SET name = '$name', description = '$description', create_date = now() WHERE markets_id = '$marketId';";
    } else {
        $sql = "UPDATE markets SET name = '$name', map_img = '$targetFileMap', description = '$description', create_date = now() WHERE markets_id = '$marketId';";
    }

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; // get last market id insert

        if ($targetFileCover == null) {
            header('Location: my_market.php');
            exit;
        } else {
            $sql = "UPDATE markets_img SET img_url = '$targetFileCover' WHERE markets_img_id = " . $myMarket['markets_img_id'];
            if ($conn->query($sql) === TRUE) {
                header('Location: my_market.php');
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
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
    <h3 class="card-title">แก้ไขตลาด</h3>
    <form method="POST" enctype="multipart/form-data" id="myform">
        <div id="container" class="panel card">
            <div class="card-body">
                <label><i class="fa fa-file-image-o" aria-hidden="true"></i> รูปหน้าปกตลาด</label>
                <div class="img-area-wrapper text-center"><img id="image_preview_cover" alt="IMG PREVIEW"
                                                               src="<?php echo $myMarket['img_url']; ?>"></div>
                <div class="form-group">
                    <input type='file' id="inputFileImgCover" class="form-group" name="fileImgCover"/>
                    <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                        <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
                    </div>
                </div>
                <label><i class="fa fa-map" aria-hidden="true"></i> รูปแผนที่ตลาด</label>
                <div class="form-group">
                    <div class="img-area-wrapper text-center"><img id="image_preview_map" alt="IMG PREVIEW"
                                                                   src="<?php echo $myMarket['map_img']; ?>"></div>
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
                           autocomplete="off" value="<?php echo $myMarket['name']; ?>">
                </div>
                <div class="form-group">
                    <label>คำอธิบาย</label>
                    <textarea type="text" class="form-control" placeholder="คำอธิบาย"
                              name="description"><?php echo $myMarket['description']; ?></textarea>
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
