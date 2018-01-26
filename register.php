<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
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
        <div class="col-md-6">
            <a href="register_user.php">
                <div class="card form-group">
                    <div class="text-center"><img src="img/user.png" width="140px"></div>
                    <div class="card-container">
                        <h4 class="text-center">ส่วนของพ่อค้า/แม่ค้า</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="register_market.php">
                <div class="card form-group">
                    <div class="text-center"><img src="img/online-store.png" width="140px"></div>
                    <div class="card-container">
                        <h4 class="text-center">ส่วนของเจ้าของตลาด</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
<style>
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
        border-radius: 4px;
        padding: 15px 25px;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    a:hover {
        text-decoration: none;
    }

    a{
        color:black;
    }
</style>
