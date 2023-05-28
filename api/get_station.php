<?php 

include_once "db.php";

//建立取得指定id的站點資料，其中id是由前端以ajax的方式以get方法傳送過來
$sql="select * from `station` where `id`='{$_GET['id']}'";

//執行查詢資料SQL語法並取得資料
$row=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

//使用json_encode()函式把資料轉成json格式並傳給前端
echo json_encode($row);