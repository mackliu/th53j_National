<?php include_once "db.php";

$sql="delete from `{$_POST['table']}` where `id`='{$_POST['id']}'";

$pdo->exec($sql);

header("location:../admin.php?pos={$_POST['table']}}");
