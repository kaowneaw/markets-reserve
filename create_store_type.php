<?php
ob_start(); // ใช้เมื่อเราต้องเปลี่ยน header redirect ให้กับ php

require('./common/header.php');
require('./common/db_connect.php');
if (!isset($_GET['marketId'])) {
    header('Location: create_market.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['type'])) {

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
<div class="container">
    <h3 class="card-title">สร้างประเภทของร้านค้า</h3>
    <form method="POST">
        <div id="container" class="panel card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-3"><label>ชื่อประเภทร้านค้า</label></div>
                    <div class="col-md-9"><input type="text" class="form-control" placeholder="ชื่อประเภทร้านค้า" name="type[0][name]" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"><label>ราคา</label></div>
                    <div class="col-md-9"><input type="text" class="form-control" placeholder="ราคา" name="type[0][price]" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"><label>สี</label></div>
                    <div class="col-md-9"><input type="text" class="form-control" placeholder="สี" name="type[0][color]" required></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"><label>คำอธิบาย</label></div>
                    <div class="col-md-9"><textarea type="text" class="form-control" placeholder="คำอธิบาย" name="type[0][description]"></textarea></div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                </div>
            </div>
        </div>
    </form>
    <h3 class="card-title">รายการประเภทตลาด</h3>
    <?php

    $sql = "SELECT * FROM store_type";
    $result = $conn->query($sql);
    echo '<table class="table">';
    echo '<thead>';
    echo ' <tr>';
    echo '<th scope="col">#</th>';
    echo '  <th scope="col">ชื่อประเภท</th>';
    echo '  <th scope="col">Last Name</th>';
    echo '  <th scope="col">Username</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo'<tr>';
            echo'<td>'.$rows[type_name].'</td>';
            echo"</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    ?>
</div>
</body>
</html>
<style>
</style>
<script>
    $(document).ready(function () {
        var index = 0;
        $("#btnAdd").click(function (){
            index++;
            $("#container").append(
            '<div class="card-body">' +
            '   <h4>ประเภทที่ '+ (index + 1) +'</h4>'+
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>ชื่อประเภทร้านค้า</label></div>' +
            '       <div class="col-md-9"><input type="text" class="form-control" placeholder="ชื่อประเภทร้านค้า" name="type['+index+'][name]" required></div>' +
            '   </div>' +
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>ราคา</label></div>' +
            '       <div class="col-md-9"><input type="text" class="form-control" placeholder="ราคา" name="type['+index+'][price]" required></div>' +
            '   </div>' +
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>สี</label></div>' +
            '       <div class="col-md-9"><input type="text" class="form-control" placeholder="สี" name="type['+index+'][color]" required></div>' +
            '   </div>' +
            '   <div class="form-group row">' +
            '       <div class="col-md-3"><label>คำอธิบาย</label></div>' +
            '       <div class="col-md-9"><textarea type="text" class="form-control" placeholder="คำอธิบาย" name="type['+index+'][description]"></textarea></div>' +
            '   </div>' +
            '   <div class="text-right"><button class="btn btn-danger remove-item" type="button">&nbsp;ลบ&nbsp;</button></div>' +
            '</div>'
            );

            $( ".remove-item" ).bind( "click", function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        });

    });
</script>