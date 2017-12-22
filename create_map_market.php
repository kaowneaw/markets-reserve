<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start();
if (!isset($_GET['marketId'])) {
    header('Location: create_market.php');
} else {
    $marketId = $_GET['marketId'];
    $sql = "SELECT * FROM markets WHERE markets_id = '$marketId' limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $img = $row['map_img'];
        }
    } else {
        echo "0 results";
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
<div class="container-fluid pd-top">
    <h3 class="card-title">Map Markets</h3>
    <div class="map-area-wrapper" id="wrapper-map">
        <img id="image_upload_preview" />
    </div>
    <div class="row">
        <div class="col-xs-12 form-group"></div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style>
    .map-area-wrapper {
        /*width: 1260px;*/
        /*height: 620px;*/
        margin: 0 auto;
        overflow: auto;
        border: solid black 1px;
        background-color: black;
    }

</style>
<script>
    $(document).ready(function () {
        initPlanit();
    });

    var addMode = true;
    function initPlanit() {
        p = planit.new({
            container: 'wrapper-map',
            image: {
                url: "<?php echo $img; ?>",
                zoom: true
            },
            markerDragEnd: function(event, marker) {
                // console.log(marker.position());
                // console.log(marker.coords());
            },
            markerClick: function(event, marker) {
//                p.centerOn(marker.position());
                setTimeout(marker.showInfobox, 100);
            },
            canvasClick: function(event, coords) {
                if(addMode) {
                    p.addMarker({
                        coords: coords,
                        size: 20,
                        color: '#12abe3',
                        draggable: true
                    });
                }
                addMode = false;
            }
        });
    }


</script>
