<?php include_once "db.php";

$sql="insert into `bus` (`name`,`minute`) value('{$_POST['name']}','{$_POST['minute']}')";

$pdo->exec($sql);

header("location:../admin.php?pos=bus");
