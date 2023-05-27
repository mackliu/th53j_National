<?php 

include_once "db.php";

$sql="select * from `station` where `id`='{$_GET['id']}'";
$row=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

echo json_encode($row);