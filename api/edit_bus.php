<?php include_once "db.php";

//建立編輯接駁車資料SQL語法
$sql="update `bus` set `minute`='{$_POST['minute']}' where `id`='{$_POST['id']}'";

//執行編輯接駁車資料SQL語法
$pdo->exec($sql);

//執行完畢返回後台的接駁車管理頁面
header("location:../admin.php?pos=bus");
