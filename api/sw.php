<?php include_once "db.php";

$first=$pdo->query("select * from `station` where `id`='{$_POST['ids'][0]}'")->fetch(PDO::FETCH_ASSOC);
$second=$pdo->query("select * from `station` where `id`='{$_POST['ids'][1]}'")->fetch(PDO::FETCH_ASSOC);

//檢查要交換的資料中是否有首站,如果有則需同時交換行駛時間資料
$minBefore=$pdo->query("select min(`before`) from `station`")->fetchColumn();
if($chk=array_search($minBefore,["{$first['id']}"=>$first['before'],
                            "{$second['id']}"=>$second['before']])){
                                $pdo->exec("update `station` set `before`='{$second['before']}',`minute`='{$second['minute']}' where `id`='{$first['id']}'");
                                $pdo->exec("update `station` set `before`='{$first['before']}',`minute`='{$first['minute']}' where `id`='{$second['id']}'");                            

}else{
    $pdo->exec("update `station` set `before`='{$second['before']}' where `id`='{$first['id']}'");
    $pdo->exec("update `station` set `before`='{$first['before']}' where `id`='{$second['id']}'");
}
