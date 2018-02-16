<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Market Reserve</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                if(isset($_SESSION["user"])) {
                    if($_SESSION["user"]->role == 'USER') {
                        if($_SESSION["user"]->type == 'MARKET') {
                            echo '<li class="dropdown">';
                            echo '   <a href="#" class="dropdown-toggle" data-toggle="dropdown">ตลาด <b class="caret"></b></a>';
                            echo '   <ul class="dropdown-menu">';
                            echo '       <li><a href="my_market.php">ตลาดของฉัน</a></li>';
                            echo '       <li><a href="create_market.php">สร้างตลาด</a></li>';
                            echo '  </ul>';
                            echo '</li>';
                            echo '<li><a href="my_account_bank_promtpay.php">ข้อมูลบัญชีธนาคาร</a></li>';
                            $NavuserId = $_SESSION["user"]->users_id;
                            $Navsql = "SELECT * FROM report_transfer rt INNER JOIN (SELECT store_booking.*,markets.userId,markets.name as market_name FROM store_booking INNER JOIN markets ON store_booking.market_id = markets.markets_id WHERE markets.userId = '$NavuserId') sb ON rt.booking_id = sb.store_booking_id INNER JOIN users ON users.users_id = sb.user_id WHERE sb.status = 'REPORTED' ORDER BY rt.report_transfer_id DESC";
                            $Navresult = $conn->query($Navsql);

                            if($Navresult->num_rows > 0) {
                                echo '<li><a href="notify_transfer_list.php">รายการแจ้งโอนเงิน <div class="noti">'.$Navresult->num_rows.'</div></a></li>';
                            } else {
                                echo '<li><a href="notify_transfer_list.php">รายการแจ้งโอนเงิน </a></li>';
                            }
                            echo '<li class="dropdown">';
                            echo '   <a href="#" class="dropdown-toggle" data-toggle="dropdown">รายงาน <b class="caret"></b></a>';
                            echo '   <ul class="dropdown-menu">';
                            echo '       <li><a href="report_income.php">รายงานรายได้</a></li>';
                            echo '  </ul>';
                            echo '</li>';
                        } else {
                            echo '<li>';
                            echo '   <a href="my_reserve.php">รายการจองของฉัน</a>';
                            echo '</li>';
                        }
                        echo '<li>';
                        echo '   <a href="contract.php">ใบสัญญา</a>';
                        echo '</li>';
                    } else {
                        // role admin
                        echo '<li>';
                        echo '   <a href="manage_user.php">จัดการผู้ใช้งาน</a>';
                        echo '</li>';
                        echo '<li>';
                        echo '   <a href="reports.php">รายงาน</a>';
                        echo '</li>';
                    }

                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (isset($_SESSION["user"]) && $_SESSION["user"]) {
                    echo '<li><img src="'.$_SESSION["user"]->img.'" width="32px" height="32px" style="margin-top: 10px" class="img-circle"/></a></li>';
                    echo '<li><a>USER: '.$_SESSION["user"]->username.'</a></li>';
                    echo '<li><a href="edit_user.php?userId='.$_SESSION["user"]->users_id.'">แก้ไขโปรไฟล์</a></li>';
                    echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
                } else {
                    echo '<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                    echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<style>
    .noti {
        width: 24px;
        height: 24px;
        text-align: center;
        background-color: red;
        border-radius: 50%;
        font-size: 12px;
        padding-top: 3px;
        color:white;
        display: inline-block;
    }
</style>