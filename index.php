<?php
require('./common/header.php');
require('./common/db_connect.php');
session_start(); // Starting Session

$sql = "SELECT * FROM markets INNER JOIN users ON markets.userId = users.users_id LEFT JOIN markets_img ON markets.markets_id = markets_img.market_id ORDER BY markets_id DESC ";
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
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 form-group">';
                echo '<a href="reserve_market.php?marketId='.$row['markets_id'].'&startDate='.date("d/m/Y").'&endDate='.date("d/m/Y").'">';
                echo '    <div class="card">';
                echo '      <img src="' . $row['img_url'] . '">';
                echo '    <div class="card-container">';
                echo '        <small>ชื่อตลาด</small>';
                echo '        <h4>' . $row["name"] . '</h4>';
                echo '        <div class="text-right"><small>เจ้าของตลาด '.$row["first_name"].' '.$row["last_name"].'</small></div>';
                echo '    </div>';
                echo '    </div>';
                echo '</a>';
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
        $(".alert").alert();
    });
</script>