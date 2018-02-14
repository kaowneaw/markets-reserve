<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start(); // Starting Session

if (!$_SESSION["user"]) {  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}
if (!isset($_GET['reserveId'])) {
    header('Location: index.php');
} else {

    $reserveId = $_GET['reserveId'];
    $sql = "SELECT * FROM (SELECT deposit,store_market_id,store_name,type_id,market_type_name,width,height,markets.name FROM market_store ms INNER JOIN markets_type mt ON ms.type_id = mt.markets_type_id INNER JOIN markets ON markets.markets_id = ms.markets_id ) store  
    INNER JOIN ( SELECT * FROM store_booking sb INNER JOIN store_booking_detail sbd ON sb.store_booking_id = sbd.booking_id  WHERE store_booking_id = '$reserveId' ) booking ON store.store_market_id = booking.store_id";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $reserve = $row; // ข้อมูลการจอง
        }
    } else {
        echo "No Results";
    }

    $sql = "SELECT * FROM report_transfer WHERE booking_id = '$reserveId'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $reportData = $row; // ข้อมูลแจ้งโอนเงิน
        }
    } else {
        echo "No Results";
    }

    if(isset($_POST['approvePayment'])) {
        $reserveId = $_POST['approvePayment'];
        $sql = "UPDATE store_booking SET status = 'APPROVE' WHERE store_booking_id = ".$reserveId; // update สถานะ เป็นจ่ายเงินแล้ว
        if ($conn->query($sql) === TRUE) {
            header('Location: notify_transfer_list.php'); // redirect to page
        } else {
            $hasError = true;
            $error = $conn->error;
        }
    }


    // upload สัญญา
    if(isset($_FILES['fileContract'])) {
        // upload img map
        if (isset($_FILES["fileContract"]) && $_FILES["fileContract"]['error'] == 0) {
            $extensionImgMap = pathinfo($_FILES["fileContract"]["name"], PATHINFO_EXTENSION);
            if (strtolower($extensionImgMap) != "jpg" && strtolower($extensionImgMap) != "jpeg" && strtolower($extensionImgMap) != "png") {
                echo "<script type='text/javascript'>window.alert('รูปแผนที่ตลาด สนับสนุนเฉพาะไฟล์ประเภท JPG JPEG และ PNG');window.location.href='notify_transfer_list_detail.php';</script>";
                return false;
            }

            $newFilenameMap = round(microtime(true)) . 'map.' . $extensionImgMap; //สร้างชื่อไฟล์รอ หน่วยไมโคร
            $targetFileMap = "uploads/" . $newFilenameMap;

            if (move_uploaded_file($_FILES["fileContract"]["tmp_name"], $targetFileMap)) {

            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }else {
            echo "<script type='text/javascript'>window.alert('กรุณาเลือกรูปแผนที่ตลาด');window.location.href='notify_transfer_list_detail.php';</script>";
            return false;
        }

        $sql = "INSERT INTO `contract` (`contract_img`, `store_booking_id`) VALUES ('$targetFileMap', '$reserveId');";
        if ($conn->query($sql) === TRUE) {
            header('Location: notify_transfer_list_detail.php?reserveId=' . $reserveId);
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
    <div class="row">
        <div class="col-xs-6">
            <h3 class="card-title text-white form-group">รายละเอียดการแจ้งโอนเงิน</h3>
        </div>
        <div class="col-xs-6 text-right">
            <button class="btn btn-success form-group" id="addContract" style="margin-top: 10px">เพิ่มรูปสัญญาเช่า</button>
        </div>
    </div>
    <div id="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    &nbsp;
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ชื่อ</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['store_name'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วันที่เริ่มต้น</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['start_date'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วันที่สิ้นสุด</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['end_date'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ชื่อตลาด</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['name'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ประเภท</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['market_type_name'] ?></label>
                        </div>
                    </div>
                    <?php
                    if ($reserve['type_id'] != 1) {
                        echo '<div class="row form-group">';
                        echo '   <div class="col-xs-4">';
                        echo '    <label class="control-label">ชำระเงินมัดจำ</label>';
                        echo '   </div>';
                        echo '    <div class="col-xs-8">';
                        echo '      <label class="control-label">'.$reserve['deposit'] .' บาท</label>';
                        echo '    </div>';
                        echo '</div>';
                    }
                    ?>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ค่าเช่า</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['price'] . ' บาท' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ค่าน้ำ/หน่วย</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['water_price_per_unit'] . ' บาท' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ค่าไฟ/หน่วย</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['eletric_price_per_unit'] . ' บาท' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ความกว้าง</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['width'] . ' เมตร' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">ความยาว</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['height'] . ' เมตร' ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">สถานะ</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label">
                                <?php
                                if($reserve["status"] === 'WAIT') {
                                    echo 'รอการชำระเงิน';
                                } else if($reserve["status"] === 'REPORTED'){
                                    echo 'แจ้งโอนเงินแล้ว';
                                } else if ($reserve["status"] === 'APPROVE') {
                                    echo 'ชำระเงินแล้ว';
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วันที่ทำรายการ</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reserve['create_date'] ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col1 -->
            <div class="col-md-6">
                <div class="panel">
                    <div class="text-right">
                        <form method="POST">
                            <input type="hidden" value="<?php echo $reserveId; ?>" name="approvePayment">
                            <?php
                                if($reserve["status"] === 'REPORTED') {
                                    echo '<button class="btn btn-success">ยืนยันการชำระเงิน</button>';
                                }
                             ?>
                        </form>
                    </div>
                    &nbsp;
                    <div class="row form-group">
                        <div class="col-xs-12">
                            <img class="img-responsive" src="<?php echo $reportData['attachment'] ?>" style="margin: 0 auto;"/>
                        </div>
                    </div>
                    &nbsp;
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">โอนจากธนาคาร</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reportData['bank_account_from'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">โอนเข้าบัญชีธนาคาร</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reportData['bank_account_to'] ?></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-4">
                            <label class="control-label">วัน-เวลาที่ทำรายการโอนเงิน</label>
                        </div>
                        <div class="col-xs-8">
                            <label class="control-label"><?php echo $reportData['date_time'] ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<!-- Modal popup-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">เพิ่มรูปสัญญาเช่า</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="form" enctype="multipart/form-data">
                    <label><i class="fa fa-file-image-o" aria-hidden="true"></i> รูปสัญญาเช่า</label>
                    <div class="img-area-wrapper text-center"><img id="image_preview_cover" alt="IMG PREVIEW"></div>
                    <div class="form-group">
                        <input type='file' id="fileContract" class="form-group" name="fileContract"/>
                        <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                            <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg .jpeg .png
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <button class="btn btn-primary" type="submit">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
    .card-body {
        padding: 25px;
    }
    .panel {
        padding: 25px;
    }
</style>
<script>
    $(document).ready(function () {
        $("#addContract").click(function () {
            $('#myModal').modal('show');
        });

        $("#fileContract").change(function () {
            readURL(this);
        });
    });

    function readURL(input) {
        //display img from file
        if (input.files && input.files[0]) {
            if (input.files[0].name.split('.').pop().toUpperCase() !== 'JPG' && input.files[0].name.split('.').pop().toUpperCase() !== 'JPEG' && input.files[0].name.split('.').pop().toUpperCase() !== 'PNG') {
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
</script>
