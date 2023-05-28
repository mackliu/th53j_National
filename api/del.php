<?php include_once "db.php";

//建立刪除資料SQL語法，其中資料表名稱及資料ID都是由前端以ajax的方式以POST方法傳送至後端
$sql="delete from `{$_POST['table']}` where `id`='{$_POST['id']}'";

//執行刪除資料SQL語法
$pdo->exec($sql);

//刪除完畢回到後台的相應管理頁面
header("location:../admin.php?pos={$_POST['table']}}");
