<?php include_once "db.php";

//建立編輯站點資料SQL語法
$sql="update `station` 
         set `minute`='{$_POST['minute']}',
             `waiting`='{$_POST['waiting']}' 
       where `id`='{$_POST['id']}'";

//執行編輯站點資料SQL語法
$pdo->exec($sql);

//執行完畢返回後台的站點管理頁面
header("location:../admin.php?pos=station");
