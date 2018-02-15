<?php
require('./common/header.php');
require('./common/db_connect.php');
session_start(); // Starting Session

$sql = "SELECT * FROM contract INNER JOIN store_booking ON contract.store_booking_id = store_booking.store_booking_id INNER JOIN markets ON markets.markets_id = store_booking.market_id ";
$result = $conn->query($sql);
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
            <h3 class="pull-left text-white">รายการสัญญาเช่า <small class="text-white">* เพิ่มเอกสารสัญญาเช่าได้ที่หน้าประวัติการชำระเงิน</small></h3>
        </div>
    </div>
        <?php
        if ($result->num_rows > 0) {
            // output data of each row แสดงตาราง
            echo '<table class="table table-bordered">';
            echo ' <thead>';
            echo '  <tr>';
            echo '    <th class="text-center col-xs-1">ลำดับ</th>';
            echo '    <th class="col-xs-9">สัญญาเช่า</th>';
            echo '    <th class="col-xs-2">เครื่องมือ</th>';
            echo '  </tr>';
            echo '</thead>';
            echo '<tbody>';
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                $count++;
                echo '  <tr>';
                echo '    <td class="text-center">' . $count . '</td>';
                echo '    <td>ตลาด ' . $row["name"] . '</td>';
                echo '    <td>';
                echo '      <button class="btn btn-primary pull-left" onclick="view(\''.$row["contract_img"].'\')" style="margin-right: 5px;">ดู</button>';
                echo '    </td>';
                echo '  </tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<h4 class="text-center text-white"> 0 results</h4>';
        }
        ?>
</div>
</body>
<!-- Modal popup-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">รูปสัญญาเช่า</h4>
            </div>
            <div class="modal-body">
                <img class="img-responsive" id="img-show"/>
            </div>
        </div>
    </div>
</div>
</html>
<style>
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);,
        transition: 0.3s;
        background-color: white;
        border-radius: 4px;
    }

    .card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .card:hover {
        box-shadow: 0 10px 26px 0 rgba(0, 0, 0, 0.5);
    }

    .card-container {
        padding: 16px 8px;
    }

    a:hover {
        text-decoration: none;
    }

    a{
        color:black;
    }

</style>
<script>
    function view (imgSrc) {
        $('#img-show').attr('src', imgSrc);
        $('#myModal').modal('show');
    }
</script>