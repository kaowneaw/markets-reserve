<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');

// Start the session
session_start(); // Starting Session
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
        <div class="col-md-12">
            <h3 class="pull-left text-white">รายชื่อผู้ใช้งาน</h3>
        </div>
    </div>
    <table class="table table-bordered">';
        <thead>
        <tr>
            <th class="text-center col-md-1">ลำดับ</th>
            <th class="col-md-9">ชื่อ</th>
            <th class="col-md-2">เครื่องมือ</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>รายงานผู้ใช้งาน</td>
            <td class="text-center"><a href="report_user.php" class="btn btn-primary">ดู</a></td>
        </tr>
        </tbody>
    </table>

</div>
</body>
</html>
<style>
    .img-table {
        width: 100%;
        height: 80px;
        object-fit: cover;
    }

    .hide {
        display: none;
    }

    td .btn {
        /*width: 80px;*/
        margin-bottom: 5px;
    }
</style>