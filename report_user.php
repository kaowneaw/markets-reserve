<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');

// Start the session
session_start(); // Starting Session
$hasError = false;
$error = '';

if (!$_SESSION["user"]) {  //check session
    header("Location: login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form
    exit;
}

    $start_date = date('Y-m-d'); // date now default
    $end_date = date('Y-m-d');  // date now default

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
    <div class="row form-group">
        <form method="POST">
            <div class="col-xs-4">
                <div class="form-group">
                    <label for="dtp_input2" class="col-md-4 control-label text-white">วันที่เริ่มต้น</label>
                    <div class="input-group date form_date_start col-md-8" data-date="" data-date-format="dd/mm/yyyy"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input id="date_start" class="form-control" size="16" type="text" name="start_date" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <input type="hidden" id="dtp_input2" value=""/><br/>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group">
                    <label for="dtp_input2" class="col-md-4 control-label text-white">วันที่สิ้นสุด</label>
                    <div class="input-group date form_date_end col-md-8" data-date="" data-date-format="dd/mm/yyyy"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input id="date_end" class="form-control" size="16" type="text" name="end_date" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <input type="hidden" id="dtp_input2" value=""/><br/>
                </div>
            </div>
            <div class="col-xs-4">
                <button id="searchDate" class="btn btn-default">ตกลง</button>
            </div>
        </form>
    </div>
    <div id="chartContainer">

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

</style>
<script>

    $(document).ready(function () {
        $('.form_date_start').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            startDate: new Date()
        });
        $('.form_date_end').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            startDate: new Date()
        });

        var startDate = new Date("<?php echo $start_date; ?>");
        var endDate = new Date("<?php echo $end_date; ?>");

        $('#date_start').val(formatDate(startDate));
        $('#date_end').val(formatDate(endDate));
    });

    var chart = new FusionCharts ({
        "type": "column2d",
        "width": "500",
        "height": "300",
        "dataFormat": "json",
        "dataSource": {
            chart:{},
            data: [{value: 500}, {value: 600}, {value: 700}]
        }
    }).render("chartContainer");

    function formatDate(date) {
        var today;
        if (date) {
            today = date;
        } else {
            today = new Date();
        }

        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }

        return dd + '/' + mm + '/' + yyyy;
    }



</script>
