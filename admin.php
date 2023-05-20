<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-系統管理</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
</head>
<body>
<?php include "header.php";?>
<a href="?pos=bus">接駁車管理</a>
<a href="?pos=station">站點管理</a>

<?php
/*     if(isset($_GET['pos'])){
        $pos=$_GET['pos'];
    }else{
        $pos='bus';
    } */

    /* $pos=(isset($_GET['pos']))?$_GET['pos']:"bus"; */

    $pos=$_GET['pos']??'bus';

    switch($pos){
        case "bus":
            include "admin_bus.php";
        break;
        case "station":
            include "admin_station.php";
        break;
    }

?>

<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>