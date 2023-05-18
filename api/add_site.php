<?php
include "db.php";

$sql="insert into `sites`(`name`,`minute`,`waiting`) values('{$_POST['name']}','{$_POST['minute']}','{$_POST['waiting']}')";

$pdo->exec($sql);

header("location:../admin.php?do=admin_site");