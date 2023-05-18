<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-系統管理</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "header.php";?>
<?php
$target=$_GET['target']??'admin_bus';
$file=$target.".php";

if(file_exists($file)){
    include $file;
}else{
    include "admin_bus.php";
}


?>
<script src="./jquery-3.7.0.min.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>