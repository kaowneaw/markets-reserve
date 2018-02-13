<?php
require('./common/header.php');
require('./common/db_connect.php');
session_start(); // Starting Session

$sql = "SELECT * FROM contract";
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
            <h3 class="pull-left text-white">รายการสัญญาเช่า</h3>
            <button class="pull-right btn btn-success" id="addContract">เพิ่มสัญญาเช่า</button>
        </div>
    </div>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-6 form-group">';
                echo '    <div class="card">';
                if (file_exists($row['img_url'])) { // check have real file
                    echo '      <img src="' . $row['img_url'] . '">';
                } else {
                    echo '      <img src="img/store-default.png">';
                }
                echo '    </div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>
</body>
</html>
<style>
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
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
    $(document).ready(function () {
        $("#addContract").click(function () {
            $('#myModal').modal('show');
        });
    });
</script>