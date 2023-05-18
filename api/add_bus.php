<?php
include "db.php";

$sql="insert into `buses`(`plate`,`minute`) values('{$_POST['plate']}','{$_POST['minute']}')";

$pdo->exec($sql);

header("location:../admin.php?do=admin_bus");