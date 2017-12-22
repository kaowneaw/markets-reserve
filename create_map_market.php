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
            $img = $row['map_img']; // map
        }
    } else {
        echo "0 results";
    }

    $sql = "SELECT * FROM market_store WHERE markets_id = '$marketId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
            $markers = json_encode($result->fetch_assoc());
            print_r($markers);
    } else {
        echo "0 results market_store";
    }
}

// insert marker store
if(isset($_POST['price']) && isset($_POST['type']) && isset($_POST['pointX']) && isset($_POST['pointY'])) {
    $price = $_POST['price'];
    $type = $_POST['type'];
    $desc = $_POST['description'];
    $pointX = $_POST['pointX'];
    $pointY = $_POST['pointY'];

    $sql = "INSERT INTO market_store (type_id, pointX, pointY, status, price, description) VALUES ('$type', '$pointX', '$pointY', 'AVAILBLE', '$price', '$desc')";
    if ($conn->query($sql) === TRUE) {
        header('Location: create_map_market.php?marketId='.$_GET['marketId']); // refresh page
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
<div class="container-fluid pd-top">
    <h3 class="card-title">กำหนดตำแหน่งร้านค้า</h3>
    <div class="map-area-wrapper" id="wrapper-map">
        <img id="image_upload_preview" />
    </div>
    <div class="row">
        <div class="col-xs-12 form-group"></div>
    </div>
    <div id="container-form">
        <form method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="price">ค่าเช่า</label>
                    </div>
                    <div class="col-md-8">
                        <input type="number" class="form-control" placeholder="ค่าเช่า" name="price" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="price">ประเภท</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="type" required>
                            <?php
                            $sql = "SELECT * FROM markets_type";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo ' <option value="'.$row["markets_type_id"].'">'.$row["name"].'</option>';
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
                        <label for="price">รายละเอียด</label>
                    </div>
                    <div class="col-md-8">
                        <textarea type="text" class="form-control" placeholder="รายละเอียด"  name="description"></textarea>
                    </div>
                </div>
            </div>
            <div style="display: none">
                <!--not display-->
                <input type="text"  name="pointX" id="pointX" required>
                <input type="text"  name="pointY" id="pointY" required>
            </div>
            <div class="text-right">
                <button class="btn btn-primary" type="submit">เพิ่มร้านค้า</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<style>
    .map-area-wrapper {
        margin: 0 auto;
        overflow: auto;
        border: solid black 1px;
        background-color: black;
    }

    #container-form {
        max-width: 420px;
        margin: 0 auto;
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
            markers: [

            ],
            markerDragEnd: function(event, marker) {
                var position = marker.position();
                setPositionValue(position);
            },
            markerClick: function(event, marker) {
//                setTimeout(marker.showInfobox, 100);
            },
            canvasClick: function(event, coords) {
                if(addMode) {
                    setPositionValue(coords);
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


    function setPositionValue (position) {
        var pointX = position[0];
        var pointY = position[1];
        $("#pointX").val(pointX);
        $("#pointY").val(pointY);
    }


</script>
