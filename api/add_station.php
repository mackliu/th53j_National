<?php include_once "db.php";

$sql="insert into `station` (`name`,`minute`,`waiting`) value('{$_POST['name']}','{$_POST['minute']}','{$_POST['waiting']}')";

$pdo->exec($sql);

header("location:../admin.php?pos=station");
