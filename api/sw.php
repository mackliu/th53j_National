<?php include_once "db.php";

$first=$pdo->query("select * from `station` where `id`='{$_POST['ids'][0]}'")->fetch(PDO::FETCH_ASSOC);
$second=$pdo->query("select * from `station` where `id`='{$_POST['ids'][1]}'")->fetch(PDO::FETCH_ASSOC);
$pdo->exec("update `station` set `before`='{$second['before']}' where `id`='{$first['id']}'");
$pdo->exec("update `station` set `before`='{$first['before']}' where `id`='{$second['id']}'");