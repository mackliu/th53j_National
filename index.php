<?php include_once "./api/db.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-路網圖</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <style>

        .block{
            width:200px;
            height:100px;
            border:1px solid #ccc;

        }
    </style>
</head>
<body>
<?php include "header.php";?>
<div class="d-flex flex-wrap " style="width:600px">
<?php 
$sql="select * from `station`";
$stations=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$tmp=[];
foreach($stations as $key => $station){
    $tmp[floor($key/3)][]=$station;
}
/* echo "<pre>";
print_r($tmp);
echo "</pre>"; */

foreach($tmp as $k => $t){
    if($k%2==1){
        krsort($t);
        $tmp[$k]=$t;
    }
}

/* echo "<pre>";
print_r($tmp);
echo "</pre>"; */

foreach($tmp as $t){
    foreach($t as $station){
        echo "<div class='block'>";
        echo $station['name'];
        echo "</div>";
    }
}


?>

</div>
<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>