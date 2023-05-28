<?php 
include_once "db.php";

//建立新增接駁車SQL語法
$sql="insert into `bus` (`name`,`minute`) value('{$_POST['name']}','{$_POST['minute']}')";

//執行新增接駁車SQL語法
$pdo->exec($sql);

//新增完畢返回後台的接駁車管理頁面
header("location:../admin.php?pos=bus");
