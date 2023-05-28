<?php include_once "db.php";

//建立新增站點SQL語法
$sql="insert into `station` (`name`,`minute`,`waiting`) 
                       values('{$_POST['name']}',
                             '{$_POST['minute']}',
                             '{$_POST['waiting']}')";
//執行新增站點SQL語法
$pdo->exec($sql);

//新增完畢返回後台的站點管理頁面
header("location:../admin.php?pos=station");
