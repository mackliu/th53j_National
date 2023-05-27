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
            position:relative;


        }
        .point{
            width:25px;
            height:25px;
            border-radius:50%;
            background-color:skyblue;
            display: flex;
            justify-content:center;
            align-items:center;
            position:relative;
            z-index:10;
        }
        .point::before{
            content:"";
            width:20px;
            height:20px;
            border:3px solid white;
            border-radius:50%;
        }
        .right::after{
            content:"";
            width:50%;
            height:18px;
            background-color:skyblue;
            position:absolute;
            right:0;
        }
        .left::after{
            content:"";
            width:50%;
            height:18px;
            background-color:skyblue;
            position:absolute;
            left:0;
        }
        .line::after{
            content:"";
            width:100%;
            height:18px;
            background-color:skyblue;
            position:absolute;
            left:0;
        }
        .connect{
            width:18px;
            height:100px;
            background:skyblue;
            top:50%;
        }
        .connect-right{
            position:absolute;
            right:0;
        }
        .connect-left{
            position:absolute;
            left:0;
        }
    </style>
</head>
<body>
<?php include "header.php";?>
<div class="d-flex flex-wrap " style="width:600px">
<?php 
$sql="select * from `station`";
$stations=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$timer=[];
$arrive=0;
$leave=0;
foreach($stations as $station){
    $arrive=$leave+$station['minute'];
    $leave=$arrive+$station['waiting'];

    $timer[$station['name']]['arrive']=$arrive;
    $timer[$station['name']]['leave']=$leave;
}
/*  echo "<pre>"; 
 print_r($timer); 
 echo "</pre>";  */

$tmp=[];
foreach($stations as $key => $station){
    $tmp[floor($key/3)][]=$station;
}
/*   echo "<pre>"; 
 print_r($tmp); 
 echo "</pre>";  */ 

foreach($tmp as $k => $t){
    if($k%2==1){
        $tmp[$k]=array_reverse($t);
    }
}

/* echo "<pre>";
print_r($tmp);
echo "</pre>"; */

//所有的車子資料撈出來
$sql="select * from `bus` ";
$buses=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

foreach($tmp as $key => $t){
    if($key%2==1){
        echo "<div class='d-flex w-100 justify-content-end position-relative'>";
    }else{
        echo "<div class='d-flex w-100 position-relative'>";
    }

    if((ceil(count($stations)/3)-1)>$key){
        if($key%2==1){
            echo "<div class='connect connect-left'></div>";
        }else{
            echo "<div class='connect connect-right'></div>";
        }
    }

    foreach($t as $k => $station){

        if($key==0 && $k==0 ){
            echo "<div class='block right'>";
        }else if($key==ceil(count($stations)/3)-1){
       
            if($key%2==0){
                if($k==count($t)-1){
                    echo "<div class='block left'>";
                }else{
                    echo "<div class='block line'>";        
                }
            }else{
                if($k==0){
                    echo "<div class='block right'>";
                }else{
                    echo "<div class='block line'>";
                }
            }
        }else{
            echo "<div class='block line'>";
        }
        
        $gap=[];
        foreach($buses as $bus){
            if($bus['minute']-$timer[$station['name']]['arrive']>=0 && $bus['minute']-$timer[$station['name']]['leave']<=0){
                echo $bus['name'];
                echo "已到站";
            }else if($bus['minute']-$timer[$station['name']]['arrive']<0 ){
                $gap[$bus['name']]=abs($bus['minute']-$timer[$station['name']]['arrive']);
            }
        }
        if(!empty($gap)){
            $min=min($gap);
            $name=array_search($min,$gap);
            echo $name ;
            echo "約".$min."分鐘";
        }
        
        $gap=[];


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