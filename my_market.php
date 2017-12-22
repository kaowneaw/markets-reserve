<?php
require('./common/header.php');
require('./common/db_connect.php');
$userId = '1';
$sql = "SELECT * FROM markets LEFT JOIN markets_img ON markets.markets_id = markets_img.market_id WHERE userId = '$userId'";
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
    <h3>รายชื่อตลาด</h3>
    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        echo '<div class="row form-group">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-6">';
            echo '    <a href="create_map_market.php?marketId='.$row["markets_id"].'">';
            echo '    <div class="card">';
            echo '        <div class="card-container">';
            echo '        <div><small>ชื่อตลาด</small><small class="pull-right">'.$row["create_date"].'</small></div>';
            echo '        <h5>' . $row["name"] . '</h5>';
            echo '        <div class="container-img"><img src="' . $row["img_url"] . '" class="market-img" /></div>';
            echo '        <small>รายละเอียด</small>';
            echo '        <p>'.$row["description"].'</p>';
            echo '        </div>';
            echo '    </div>';
            echo '    </a>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "0 results";
    }
    ?>

</div>
</body>
</html>
<style>
    .card-container {
        padding: 15px;
    }
    a {
        color: black !important;
    }
    a:hover {
        color: black !important;
        text-decoration: none !important;
    }
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        margin: 10px;
    }
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .container-img {
        width: 220px;
        height: 220px;
        margin: 0 auto;
    }

    .container-img img {
        width: 100%;
    }
</style>
<script>
    $(document).ready(function () {
        $(".alert").alert();
    });
</script>