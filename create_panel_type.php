<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('header.php');
require('db_connect.php');

if(isset($_POST['type'])){
    
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
                <a class="nav-link" href="create_market.php">Home <span class="sr-only">(current)</span></a>
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
    <h3 class="card-title">ระบุประเภทของร้านค้า</h3>
    <form method="POST">
        <div class="text-right form-group">
            <button class="btn btn-primary" type="submit">บันทึก</button>&nbsp;
            <button id="btnAdd" type="button" class="btn btn-success">+ เพิ่มประเภท</button>
        </div>
        <div id="container" class="panel card">
            <div class="card-body">
                <h4>ประเภทที่ 1</h4>
                <div class="form-group row">
                    <div class="col-md-3"><label>ชื่อประเภทร้านค้า</label></div>
                    <div class="col-md-9"><input type="text" class="form-control" placeholder="ชื่อประเภทร้านค้า" name="type[0][name]" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"><label>ราคา</label></div>
                    <div class="col-md-9"><input type="text" class="form-control" placeholder="ราคา" name="type[0][price]" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"><label>สี</label></div>
                    <div class="col-md-9"><input type="text" class="form-control" placeholder="สี" name="type[0][color]" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"><label>คำอธิบาย</label></div>
                    <div class="col-md-9"><textarea type="text" class="form-control" placeholder="คำอธิบาย" name="type[0][description]"></textarea></div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
<style>
    .card-body {
        border-style: solid;
        border-color: black;
        border-width: 1px;
    }
</style>
<script>
    $(document).ready(function () {
        var index = 0;
        $("#btnAdd").click(function (){
            index++;
            $("#container").append(
            '<div class="card-body">' +
            '   <h4>ประเภทที่ '+ (index + 1) +'</h4>'+
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>ชื่อประเภทร้านค้า</label></div>' +
            '       <div class="col-md-9"><input type="text" class="form-control" placeholder="ชื่อประเภทร้านค้า" name="type['+index+'][name]" required></div>' +
            '   </div>' +
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>ราคา</label></div>' +
            '       <div class="col-md-9"><input type="text" class="form-control" placeholder="ราคา" name="type['+index+'][price]" required></div>' +
            '   </div>' +
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>สี</label></div>' +
            '       <div class="col-md-9"><input type="text" class="form-control" placeholder="สี" name="type['+index+'][color]" required></div>' +
            '   </div>' +
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>คำอธิบาย</label></div>' +
            '       <div class="col-md-9"><textarea type="text" class="form-control" placeholder="คำอธิบาย" name="type['+index+'][description]"></textarea></div>' +
            '   </div>' +
            '   <div class="text-right"><button class="btn btn-danger remove-item" type="button">&nbsp;ลบ&nbsp;</button></div>' +
            '</div>'
            );

            $( ".remove-item" ).bind( "click", function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        });

    });
</script>