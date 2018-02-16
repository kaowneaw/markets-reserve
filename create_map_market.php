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
    header('Location: create_market.php');
} else {
    $marketId = $_GET['marketId'];
    $sql = "SELECT * FROM markets WHERE markets_id = '$marketId' limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $img = $row['map_img']; // map
        }
    } else {
        echo "0 results";
    }

    // get store
    $sql = "SELECT * FROM market_store INNER JOIN markets_type ON market_store.type_id = markets_type.markets_type_id WHERE markets_id = '$marketId'";
    $result = $conn->query($sql);
    $stores = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($stores, $row);
        }
    }
    $stores = json_encode($stores);
}

// insert marker store
if (isset($_POST['price']) && isset($_POST['type']) && isset($_POST['pointX']) && isset($_POST['pointY']) && isset($_POST['store_name'])) {

    $store_name = $_POST['store_name'];
    $action = $_POST['action'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $desc = "-";
    $zone = $_POST['zone'];
    $pointX = $_POST['pointX'];
    $pointY = $_POST['pointY'];
    $id = $_POST['storeId'];
    $water_price = $_POST['water_price'];
    $eletric_price = $_POST['eletric_price'];
    $height = $_POST['height'];
    $width = $_POST['width'];
    $size_marker = $_POST['sizeMarkerForm'];
    $angleMarkerForm = $_POST['angleMarkerForm'];

    if($action === "แก้ไข") {
        $sql = "UPDATE market_store SET store_name = '$store_name',type_id = '$type', price = '$price', description = '$desc', zone = '$zone', water_price_per_unit = '$water_price',eletric_price_per_unit = '$eletric_price',width = '$width', height = '$height' WHERE store_market_id = '$id';";
    }else if($action === "ลบ") {
        $sql = "DELETE FROM market_store WHERE store_market_id = '$id'";
    }else if($action === "บันทึก") {
        $sql = "INSERT INTO market_store (store_name,type_id, pointX, pointY, width, height, price, description, zone, markets_id, water_price_per_unit, eletric_price_per_unit, size_marker, angle_marker) VALUES ('$store_name','$type', '$pointX', '$pointY', '$width', '$height', '$price', '$desc','$zone', '$marketId', '$water_price', '$eletric_price', '$size_marker', '$angleMarkerForm')";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: create_map_market.php?marketId=' . $marketId); // refresh page
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
    <h3 class="card-title text-white">กำหนดตำแหน่งร้านค้า
        <small class="text-white">(*คลิกบนแผนที่เพื่อเพิ่มตำแหน่งร้าน)</small>
    </h3>
    <div class="row text-white" id="option-marker">
        <div class="col-xs-12 form-group">*กำหนดตัวเลือกของหมุด</div>
        <div class="col-xs-12">
            <label class="pull-left margin-right-15">ขนาดของหมุด</label>
            <div class="pull-left margin-right-15"><input id="size_marker" oninput="this.value = Math.abs(this.value)" class="form-control" type="number" value="20"></div>
            <label class="pull-left margin-right-15">องศา</label>
            <div class="pull-left margin-right-15"><input id="angleMarker" class="form-control" type="number" value="0"></div>
        </div>
    </div>
    <div class="map-area-wrapper" id="wrapper-map">
        <img id="image_upload_preview"/>
    </div>
</div>
<!-- Modal  popup-->
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
                            <div class="col-md-4">
                                <label for="price">ชื่อ</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="store_name" class="form-control" placeholder="ชื่อ" name="store_name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price">โซน</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="zone" class="form-control" placeholder="โซน" name="zone" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price">ค่าเช่า (บาท)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="price" class="form-control" placeholder="ค่าเช่า" oninput="this.value = Math.abs(this.value)" name="price" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price">ประเภท</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="type" required id="type">
                                    <?php
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
                            <div class="col-md-4">
                                <label for="price">ค่าน้ำ/หน่วย (บาท)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="water_price" class="form-control" placeholder="ค่าน้ำ" oninput="this.value = Math.abs(this.value)" name="water_price" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price">ค่าไฟ/หน่วย (บาท)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="eletric_price" class="form-control" placeholder="ค่าไฟ" oninput="this.value = Math.abs(this.value)" name="eletric_price" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price">ความกว้าง (เมตร)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="width" class="form-control" placeholder="ความกว้าง"  oninput="this.value = Math.abs(this.value)" name="width" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="price">ความยาว (เมตร)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="height" class="form-control" placeholder="ความยาว" oninput="this.value = Math.abs(this.value)" name="height" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="hide">
                        <!--not display-->
                        <input type="hidden" name="storeId" id="storeId" required>
                        <input type="hidden" name="pointX" id="pointX" required>
                        <input type="hidden" name="pointY" id="pointY" required>

                        <input type="hidden" name="sizeMarkerForm" id="sizeMarkerForm" required>
                        <input type="hidden" name="angleMarkerForm" id="angleMarkerForm" required>
                    </div>
                    <div class="text-right">
                        <input id="update" class="btn btn-warning" type="submit" name="action" value="แก้ไข"/>
                        <input id="del" class="btn btn-danger" type="submit" name="action" value="ลบ" />
                        <input id="save" class="btn btn-primary" type="submit" name="action" value="บันทึก" />
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
    }
    .hide {
        display: none;
    }

    .margin-right-15 {
        margin-right: 15px;
    }

    .ft-controls {
        background-color: green;
    }

</style>
<script>
    $(document).ready(function () {
        $("#option-marker").hide();
        initPlanit();
        $('#size_marker ,#angleMarker').on('input', function() {
            // do something
            var size = $("#size_marker").val();
            var angle = $("#angleMarker").val();

            $("#sizeMarkerForm").val(size);
            $("#angleMarkerForm").val(angle);

            $(markerLastedAdd).width(size).height(size);
            $(markerLastedAdd).css({'transform' : 'rotate('+ angle +'deg)'}); //rotate
        });
    });
    var markerLastedAdd = null;
    var addMode = true;
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
        }
        console.log(stores);
        p = planit.new({
            container: 'wrapper-map',
            image: {
                url: "<?php echo $img; ?>"
            },
            markers: stores,
            markerDragEnd: function (event, marker) {
                var position = marker.position();
                setPositionValue(position);
            },
            markerClick: function (event, marker) {
                if (marker.isDraggable()) {
                    // new marker
                    $('#save').show();
                    $('#del,#update').hide();
                    setValuePopup(null);
                } else {
                    $('#save').hide();
                    $('#del,#update').show();
                    setValuePopup(marker.id());
                }
                // p.centerOn(marker.position());
                $('#myModal').modal('show');
            },
            canvasClick: function (event, coords) {
                if (addMode) {
                    setPositionValue(coords);
                    p.addMarker({
                        coords: coords,
                        size: 20,
                        color: '#12abe3',
                        draggable: true
                    });
                    markerLastedAdd = $(".planit-markers-container .planit-marker").last(); // marker planit lasted add

                    var size = $("#sizeMarker").val();
                    var angle = $("#angleMarker").val();

                    $("#sizeMarkerForm").val(size);
                    $("#angleMarkerForm").val(angle);
                    $("#option-marker").show();
                }
                addMode = false;
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


    function setPositionValue(position) {
        var pointX = position[0];
        var pointY = position[1];
        $("#pointX").val(pointX);
        $("#pointY").val(pointY);
    }

    function setValuePopup (index) {
        if(index == null) {
            // marker new add
            $("#store_name").val('');
            $("#price").val('');
            $("#type").val(1);
            $("#desc").val('');
            $('#storeId').val(-1);
            $("#water_price").val('');
            $("#eletric_price").val('');
            $("#width").val('');
            $("#height").val('');
            $("#zone").val('');

        } else {
            var store = stores[index-1];
            $("#store_name").val(store.store_name);
            $("#price").val(store.price);
            $("#zone").val(store.zone);
            $("#type").val(store.type_id);
            $("#desc").val(store.description);
            $('#storeId').val(store.store_market_id);
            $("#pointX").val(store.pointX);
            $("#pointY").val(store.pointY);
            $("#width").val(store.width);
            $("#height").val(store.height);
            $("#water_price").val(store.water_price_per_unit);
            $("#eletric_price").val(store.eletric_price_per_unit);
        }
    }

</script>
