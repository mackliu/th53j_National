<?php include_once "db.php";

$sql="update `station` 
         set `minute`='{$_POST['minute']}',
             `waiting`='{$_POST['waiting']}' 
       where `id`='{$_POST['id']}'";

$pdo->exec($sql);

header("location:../admin.php?pos=station");
