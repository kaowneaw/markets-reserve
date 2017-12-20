<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
// Start the session
session_start();
//if (!isset($_GET['marketId'])) {
//    header('Location: create_market.php');
//}
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
        <img id="image_upload_preview" alt="IMG PREVIEW">
    </div>
    <div class="row">
        <div class="col-xs-12 form-group"></div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="alert alert-warning" role="alert" id="alert" style="display: none">
                <strong>ไฟล์ไม่สนับสนุน</strong> กรุณาเลือกไฟล์นามสกุล .jpg
            </div>
            <input type='file' id="inputFile"/>
        </div>
    </div>
    <div class="row"><button type="button" id="add-marker">ADD</button></div>
</div>
</body>
</html>
<style>
    .map-area-wrapper {
        width: 1260px;
        height: 620px;
        margin: 0 auto;
        overflow: auto;
        border: solid black 1px;
        background-color: black;
    }

</style>
<script>
    $(document).ready(function () {
        $("#inputFile").change(function () {
            readURL(this);
        });
        $("#add").click(function () {
            $("#wrapper-map").append('  <div id="drag-3" class="draggable">' +
                '            <p> with each pointer </p>' +
                '        </div>');
        });
    });

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
                $('#image_upload_preview').attr('src', e.target.result);

                initPlanit(e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function initPlanit(imgURI) {
        p = planit.new({
            container: 'wrapper-map',
            image: {
                url: imgURI,
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
//                p.zoomTo(0);
            }
        });

    }


    $('#add-marker').click(function(e){
        e.preventDefault();
        randomX = Math.random() * 100;
        randomY = Math.random() * 100;
        p.addMarker({
            coords: [randomX, randomY],
            color: '#12abe3',
            draggable: true
        })
    });

</script>
