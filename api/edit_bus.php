<?php include_once "db.php";

$sql="update `bus` set `minute`='{$_POST['minute']}' where `id`='{$_POST['id']}'";

$pdo->exec($sql);

header("location:../admin.php?pos=bus");
