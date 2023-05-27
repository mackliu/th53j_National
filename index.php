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
            display: flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;


        }
        .point{
            width:25px;
            height:25px;
            border-radius:50%;
            background-color:skyblue;
            display: flex;
            justify-content:center;
            align-items:center;
        }
        .point::before{
            content:"";
            width:20px;
            height:20px;
            border:3px solid white;
            border-radius:50%;
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

foreach($tmp as $key => $t){
    if($key%2==1){
        echo "<div class='d-flex w-100 justify-content-end'>";
    }else{
        echo "<div class='d-flex w-100'>";
    }
    foreach($t as $station){
        echo "<div class='block'>";
        echo "接駁車";
        echo "<div class='point'></div>";
        echo $station['name'];
        echo "</div>";
    }
    echo "</div>";
}


?>

</div>
<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>