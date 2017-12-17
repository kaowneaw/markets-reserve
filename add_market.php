<?php
require('header.php');
require('db_connect.php');
// Start the session
session_start();
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
    </div>
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
</nav>
<div class="container-fluid pd-top">
    <h3 class="card-title">Map Markets</h3>
    <div class="map-area-wrapper" id="wrapper">
        <img id="image_upload_preview" src="http://placehold.it/100x100" alt="your image"/>
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
</div>
</body>
</html>
<style>
    .map-area-wrapper {
        width: 1260px;
        height: 620px;
        margin: 0 auto;
        overflow: auto;
        background-color: black;
    }

</style>
<script>
    $(document).ready(function () {
        $("#inputFile").change(function () {
            readURL(this);
        });
        $("#add").click(function () {
            $("#wrapper").append('  <div id="drag-3" class="draggable">' +
                '            <p> with each pointer </p>' +
                '        </div>');
        });
    });

    function readURL(input) {
        //display img from file
        if (input.files && input.files[0]) {
            console.log(input.files[0].name.split('.').pop());
            if (input.files[0].name.split('.').pop().toUpperCase() !== 'JPG') {
                $("#alert").show();
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
