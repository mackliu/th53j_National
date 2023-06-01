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

        /*
         * 建立一個站點的基本外框
         */
        .block{
            width:300px;
            height:200px;
            /* border:1px solid #ccc; */
            display: flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            position:relative;


        }
        
        /**建立站點的外型圓點 */
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

        /**使用::before特性來建立圓點中的白圈 */
        .point::before{
            content:"";
            width:20px;
            height:20px;
            border:3px solid white;
            border-radius:50%;
        }

        .right::after,
        .left::after,
        .line::after{
            content:"";
            background-color:skyblue;
            position:absolute;
        }

        /**建立一個只畫右邊直線的class */
        .right::after{
            width:50%;
            height:8px;
            right:0;
        }

        /**建立一個只畫左邊直線的class */
        .left::after{
            width:50%;
            height:8px;
            left:0;
        }

        /**建立一個畫左右直線的class */
        .line::after{
            width:100%;
            height:8px;
            left:0;
        }

        /**建立一個畫垂直線的class */
        .connect{
            width:8px;
            height:200px;
            background:skyblue;
            top:50%;
        }

        /**建立一個讓直線靠右邊放置的class */
        .connect-right{
            position:absolute;
            right:0;
        }

        /**建立一個讓直線靠左邊放置的class */
        .connect-left{
            position:absolute;
            left:0;
        }
    </style>
</head>
<body>
<?php include "header.php";?>
<div class="d-flex flex-wrap m-auto shadow p-5" style="width:900px">
<?php 

//取出所有的站點資料
$sql="select * from `station`";
$stations=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

//建立一個空陣列用來存放每個站點的應到時間及離開時間
//時間的計算原理是每一站去累加行駛時間及停留時間
$timer=[];
$arrive=0;  //初始到站時間為0
$leave=0;   //初始離站時間為0
foreach($stations as $station){

    //到站時間為前一站的離站時間加上前一站到此站的行駛時間
    $arrive=$leave+$station['minute'];

    //離開時間為此站的到達時間加上停留時間
    $leave=$arrive+$station['waiting'];

    //以站點名稱為key名，到站時間為值存入$timer陣列中
    $timer[$station['name']]['arrive']=$arrive;

    //以站點名稱為key名，離站時間為值存入$timer陣列中
    $timer[$station['name']]['leave']=$leave;
}
/*  echo "<pre>"; 
 print_r($timer); 
 echo "</pre>";  */

 //建立一個暫存陣列，用來將站點以３站為一組做分組並存入暫存陣列中
$tmp=[];
foreach($stations as $key => $station){
    $tmp[floor($key/3)][]=$station;
}
/*   echo "<pre>"; 
 print_r($tmp); 
 echo "</pre>";  */ 
$stations=[]; //清空原本的站點陣列
//使用迴圈來檢視暫存陣列中每一組站點
foreach($tmp as $k => $t){

    //其中索引值為奇數的站點會進行反序的處理
    if($k%2==1){
        $t=array_reverse($t);
    }

    $stations = array_merge($stations,$t); //將排序後的陣列組合回原本陣列
}

/* echo "<pre>";
print_r($stations);
echo "</pre>"; */


//所有的車子資料撈出來
$sql="select * from `bus` ";
$buses=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$direction="right";//預設路網起始為向右

foreach($stations as $key => $stations){
    $group=floor($key/3);
    //判斷暫存陣列中的站點分組索引值為奇數或偶數，給予靠左或靠右的排列css
    // 餘1為靠右(justify-content-end)
    // 餘0為靠左(flex預設靠左)
    if(($key % 3==0)){

        if($group%2==1){
           echo "<div class='d-flex w-100 justify-content-end position-relative'>";
           $direction="left";  //將路網走向設為向左
       }else{
           echo "<div class='d-flex w-100 position-relative'>";
           $direction="right";  //將路網走向設為向右
       }

       
       
    }
    echo "<div class='block'>";

    echo "<div class='point'></div>";

    echo "</div>";
    if( $key%3 == 2){
        echo "</div>";
    }

}
?>

</div>
<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>