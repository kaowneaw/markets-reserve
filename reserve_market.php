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

if (!isset($_GET['marketId'])) {
    header('Location: index.php');
} else {
    $marketId = $_GET['marketId'];
//แปลงจากรูปแบบ 22/01/2018 -> 2018-01-22
    if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
        $date = str_replace('/', '-', $_GET['startDate']);
        $start_date = date('Y-m-d', strtotime($date));
        $date = str_replace('/', '-', $_GET['endDate']);
        $end_date = date('Y-m-d', strtotime($date));
    } else {
        $start_date = date('Y-m-d'); // date now default
        $end_date = date('Y-m-d');  // date now default
    }

    $sql = "SELECT * FROM markets  WHERE markets_id = '$marketId' limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $market_name = $row['name'];
            $img = $row['map_img']; // map
        }
    } else {
        echo "0 results";
    }

    // get store
    $sql = "SELECT *,CASE WHEN store_booking_detail_id IS NULL THEN 'true'ELSE 'false' END as available  FROM market_store ms  
    LEFT JOIN (SELECT store_booking_detail_id,store_id,start_date,end_date FROM store_booking_detail INNER JOIN store_booking ON store_booking_detail.booking_id = store_booking.store_booking_id WHERE store_booking.status != 'CANCEL' AND start_date <= '$start_date' AND end_date >= '$end_date') as store_detail
    ON ms.store_market_id = store_detail.store_id WHERE ms.markets_id = '$marketId' GROUP BY store_market_id";
    $result = $conn->query($sql);
    $stores = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($stores, $row);
        }
    }
    $stores = json_encode($stores); //เอาไปใช้ javasc
}

// save reserve กดจองแล้ว
if (isset($_POST['storeId'])) {
    $userId = $_SESSION["user"]->users_id;
    $store_id = $_POST['storeId'];
    $price = $_POST['price'];
    $water_price_per_unit = $_POST['water_price_per_unit'];
    $eletric_price_per_unit = $_POST['eletric_price_per_unit'];

    $sql = "INSERT INTO store_booking (user_id, market_id,create_date, status) VALUES ('$userId', '$marketId', now(), 'WAIT')";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; // get last market id insert
        $sql = "INSERT INTO store_booking_detail (booking_id, store_id, price, water_price_per_unit, eletric_price_per_unit,start_date,end_date) VALUES ('$last_id', '$store_id', '$price', '$water_price_per_unit', '$eletric_price_per_unit', '$start_date', '$end_date')";
        if ($conn->query($sql) === TRUE) {
            header('Location: reserve_detail.php?reserveId=' . $last_id);
            exit(0);
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
<div class="container-fluid">
    <div class="col-xs-12 form-group">
        <h3 class="text-white">ตลาด <?php echo $market_name ?></h3>
        <h4 class="text-white">ระบุช่วงเวลาที่ต้องการจอง</h4>
    </div>
    <div class="row">
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        <div class="col-md-4">
            <div class="form-group">
                <button id="searchDate" class="btn btn-default">ตกลง</button>
            </div>
        </div>
    </div>
    <div class="pull-left form-group">
        <div class="marker-green pull-left"></div><div class="text-white pull-left">สถานะร้านสามารถจองได้</div>
        <div class="marker-red pull-left"></div><div class="text-white pull-left">สถานะร้านไม่สามารถจองได้</div>
    </div>
    <div class="map-area-wrapper" id="wrapper-map">
        <img id="image_upload_preview"/>
    </div>
</div>
<!-- Modal popup-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">ข้อมูลร้านค้า</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ชื่อ</label>
                            </div>
                            <div class="col-xs-8">
                                <label id="store_name"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ค่าเช่า</label>
                            </div>
                            <div class="col-xs-8">
                                <label id="price"></label>
                                <input id="price_input" type="hidden" name="price"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ประเภท</label>
                            </div>
                            <div class="col-xs-8">
                                <select class="form-control" name="type" required id="type" disabled>
                             
                                    <?php
                                    //ดรอปดาว
                                    $sql = "SELECT * FROM markets_type";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo ' <option value="' . $row["markets_type_id"] . '">' . $row["market_type_name"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ค่าน้ำ/หน่วย</label>
                            </div>
                            <div class="col-xs-8">
                                <label id="water_price"></label>
                                <input id="water_price_input" type="hidden" name="water_price_per_unit"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ค่าไฟ/หน่วย</label>
                            </div>
                            <div class="col-xs-8">
                                <label id="eletric_price"></label>
                                <input id="eletric_price_input" type="hidden" name="eletric_price_per_unit"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ความกว้าง</label>
                            </div>
                            <div class="col-xs-8">
                                <label id="width"></label>
                                <input type="hidden" id="width_input" class="form-control" placeholder="ความกว้าง" name="width" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <label for="price">ความยาว</label>
                            </div>
                            <div class="col-xs-8">
                                <label id="height"></label>
                                <input type="hidden" id="height_input" class="form-control" placeholder="ความยาว" name="height" required>
                            </div>
                        </div>
                    </div>
                    <div class="hide">
                        <!--not display-->
                        <input type="hidden" name="storeId" id="storeId" required>
                        <input type="hidden" name="pointX" id="pointX" required>
                        <input type="hidden" name="pointY" id="pointY" required>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="show-error" class="pull-left text-danger text-center" style="margin-left: 35px;margin-top: 10px"></div>
                            <input id="reserve" class="btn btn-primary pull-right" type="submit" name="action" value="จอง"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style>
    .map-area-wrapper {
        margin: 25px auto;
        overflow: auto;
        border: solid black 1px;
        background-color: black;
        min-width: 1320px;
        clear: both;
    }

    .btn {
        padding-left: 25px;
        padding-right: 25px;
    }

    .marker-green {
        border-radius: 50%;
        width: 20px;
        height:20px;
        background-color: rgb(51, 204, 51);
        margin-left: 10px;
        margin-right: 10px;
    }
    .marker-red {
        border-radius: 50%;
        width: 20px;
        height:20px;
        background-color: rgb(255, 51, 0);
        margin-left: 10px;
        margin-right: 10px;
    }
</style>
<script>
    $(document).ready(function () {
        initPlanit();
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

        $('.form_date_start, .form_date_end')
            .datetimepicker()
            .on('changeDate', function (ev) {
                // change format date
                var arrDate = $("#date_start").val().split("/");
                var dateStart = new Date(arrDate[2], arrDate[1] - 1, arrDate[0]);

                var arrDate2 = $("#date_end").val().split("/");
                var dateEnd = new Date(arrDate2[2], arrDate2[1] - 1, arrDate2[0]);

                if (dateStart >= dateEnd) {
                    $('#date_end').val(formatDate(dateStart));
                }
            });

        var startDate = new Date("<?php echo $start_date; ?>");
        var endDate = new Date("<?php echo $end_date; ?>");

        $('#date_start').val(formatDate(startDate));
        $('#date_end').val(formatDate(endDate));

        $('#searchDate').click(function () {
            var marketId = "<?php echo $marketId; ?>";
            var startDate = $('#date_start').val();
            var endDate = $('#date_end').val();
            window.location = "reserve_market.php?marketId=" + marketId + "&startDate=" + startDate + "&endDate=" + endDate; //change page
        });

        $('form').submit(function () {
            // check before submit
            var typeId = $("#type").val();
            // change format date
            var arrDate = $("#date_start").val().split("/");
            var dateStart = new Date(arrDate[2], arrDate[1] - 1, arrDate[0]); // change format date to default

            var arrDate2 = $("#date_end").val().split("/");
            var dateEnd = new Date(arrDate2[2], arrDate2[1] - 1, arrDate2[0]);

            if (typeId == 1) {
                // รายวัน
                var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
                var days = Math.round(Math.abs((dateStart.getTime() - dateEnd.getTime()) / (oneDay))); // days = 0 คือวันเริ่มต้นกับวันสิ้นสุดเป็นวันเดียวกัน

            } else if (typeId == 2) {
                // รายเดือน
                var month = diff_months(dateStart, dateEnd);
                var dateDestination = dateStart;
                dateDestination.setMonth(dateDestination.getMonth() + 1);

                if(month === 0) {
                    $("#show-error").html("ประเภทรายเดือน กรุณาเลือกวันสิ้นสุดที่ " + formatDate(dateDestination));
                    return false;
                }
            }

            return true;
        });

        function diff_months(dt2, dt1) {
            var diff = (dt2.getTime() - dt1.getTime()) / 1000;
            diff /= (60 * 60 * 24 * 7 * 4);
            return Math.abs(Math.round(diff));
        }
    });

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

    var stores = [];

    function initPlanit() {
        stores = JSON.parse('<?php echo $stores; ?>');
        for (var i = 0; i < stores.length; i++) {
            var coordsArr = [];
            coordsArr.push(stores[i].pointX);
            coordsArr.push(stores[i].pointY);
            stores[i].coords = coordsArr;
            stores[i].size = 20;
            stores[i].id = i + 1; // cannot set zero

            if (stores[i].available == 'true') {
                stores[i].color = '#33cc33';
            } else {
                stores[i].color = '#ff3300';
            }
        }
        //คลุมทั้งแผนที่
        p = planit.new({
            container: 'wrapper-map',
            image: {
                url: "<?php echo $img; ?>",
                zoom: true
            },
            markers: stores,
            markerDragEnd: function (event, marker) {
                var position = marker.position();
                setPositionValue(position);
            },
            markerClick: function (event, marker) {
                p.centerOn(marker.position());
                setValuePopup(marker.id());
                $('#myModal').modal('show');
            },
            canvasClick: function (event, coords) {
                // p.zoomable.zoomIn();
            }
        });

        //set delay for dom loaded
        setTimeout(function () {
            var index = 0;
            $(".planit-marker").each(function () {
                var store = stores[index];
                // resize marker
                $(this).width(store.size_marker);
                $(this).height(store.size_marker);
                $(this).css({'transform' : 'rotate('+ store.angle_marker +'deg)'});
                index++;
            });
        }, 500)
    }
    //setค่าในpopup
    function setValuePopup(index) {
        if (index == null) {
            // marker new add
            $("#store_name").val('');
            $("#price").val('');
            $("#type").val(1);
            $("#height").val('');
            $("#width").val('');
            $('#storeId').val(-1);
        } else {
            var store = stores[index - 1];
            var typeUser = "<?php echo $_SESSION["user"]->type; ?>";
            $("#show-error").html('');

            if(typeUser === 'MARKET') {
                $("#reserve").hide();
            } else {
                if (store.available == "true") {
                    $("#reserve").show();
                } else {
                    $("#reserve").hide();
                }
            }

            
            $("#store_name").html(checkEmptyText(store.store_name));
            $("#price").html(checkEmptyText(store.price) + ' บาท');
            $("#price_input").val(store.price);
            $("#type").val(store.type_id);
            $("#desc").html(checkEmptyText(store.description));
            $('#storeId').val(store.store_market_id);
            $("#pointX").val(store.pointX);
            $("#pointY").val(store.pointY);
            $("#height").html(store.height + ' เมตร');
            $("#width").html(store.width + ' เมตร');
            $("#water_price").html(checkEmptyText(store.water_price_per_unit) + ' บาท');
            $("#water_price_input").val(store.water_price_per_unit);
            $("#eletric_price").html(checkEmptyText(store.eletric_price_per_unit) + ' บาท');
            $("#eletric_price_input").val(store.eletric_price_per_unit);
        }
    }

    function checkEmptyText(txt) {
        if (txt === '') {
            return '-';
        }
        return txt;
    }
</script>
