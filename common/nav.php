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
                        } else {
                            echo '<li>';
                            echo '   <a href="my_reserve.php">รายการจองของฉัน</a>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li>';
                        echo '   <a href="manage_user.php">จัดการผู้ใช้งาน</a>';
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