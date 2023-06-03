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

        /**建立一個只畫右邊直線的class */
        .right::after{
            content:"";
            width:50%;
            height:8px;
            background-color:skyblue;
            position:absolute;
            right:0;
        }

        /**建立一個只畫左邊直線的class */
        .left::after{
            content:"";
            width:50%;
            height:8px;
            background-color:skyblue;
            position:absolute;
            left:0;
        }

        /**建立一個畫左右直線的class */
        .line::after{
            content:"";
            width:100%;
            height:8px;
            background-color:skyblue;
            position:absolute;
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
        .block .bus-info{
            display:none;
            position:relative;
            z-index:100;
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

//使用迴圈來檢視暫存陣列中每一組站點
foreach($tmp as $k => $t){

    //其中索引值為奇數的站點會進行反序的處理
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

    //判斷暫存陣列中的站點分組索引值為奇數或偶數，給予靠左或靠右的排列css
    if($key%2==1){
        echo "<div class='d-flex w-100 justify-content-end position-relative'>";
    }else{
        echo "<div class='d-flex w-100 position-relative'>";
    }

    //根據站點總數來判斷是否要加上垂直連接線
    if((ceil(count($stations)/3)-1)>$key){

        //判斷暫存陣列中的站點分組索引值為奇數或偶數，給予垂直連接線靠左或靠右的排列css
        if($key%2==1){
            echo "<div class='connect connect-left'></div>";
        }else{
            echo "<div class='connect connect-right'></div>";
        }
    }

    //將分組中的各個站點進行顯示相關的處理
    foreach($t as $k => $station){

        //如果為起始站，則只畫右邊線
        if($key==0 && $k==0 ){
            echo "<div class='block right'>";

            //如果為最後一站，需進一步判斷是那一個方向的最後一站
        }else if($key==ceil(count($stations)/3)-1){
       
            //判斷分組索引值為奇數或偶數
            if($key%2==0){

                //如果結束在偶數的橫列，則最後站為陣列的最後一個值，只需畫左邊線
                if($k==count($t)-1){
                    echo "<div class='block left'>";
                }else{
                    echo "<div class='block line'>";        
                }
            }else{

                //如果結束在奇數的橫列，則最後站為陣列的第一個值，只需畫右邊線
                if($k==0){
                    echo "<div class='block right'>";
                }else{
                    echo "<div class='block line'>";
                }
            }
        }else{
            echo "<div class='block line'>";
        }
        
        //建立一個用來暫存接駁車與站點到達時間間隔的陣列
        //此陣列內用來判斷每一部接駁車離各站還有多少時間到達,
        $gap=[];

        //建立一個註記用的變數，用來判斷此站點是否有接駁車已到站
        //如果有接駁車已到站，則優先顯示已到站的接駁車資訊，
        //未到站的接駁車則不顯示
        $flag=0;

        //巡訪每一部接駁車，計算接駁車和此站點的時間關係
        //接駁車已行駛時間 < 站點到達時間 < 0 => 未到站
        //接駁車已行駛時間 >= 站點到達時間  && 接駁車已行駛時間 <= 站點離開時間 >= 0 => 已到站
        //接駁車已行駛時間 > 站點離開時間 => 已離站
        $relation=[];
        foreach($buses as $bus){
            $diff=$bus['minute']-$timer[$station['name']]['arrive'];
            $relation[$bus['name']]=$diff;
/*             if($bus['minute']==0){
                echo $bus['name'];
                echo "未發車";
            }else if(($bus['minute'] >= $timer[$station['name']]['arrive']) && ($bus['minute'] <= $timer[$station['name']]['leave'])){
                //接駁車已到站，顯示到站資訊
                echo $bus['name'];
                echo "已到站";

                //將$flag設為1，表示此車為已到站狀態
                $flag=1;
            }else if($bus['minute'] < $timer[$station['name']]['arrive']){

                //接駁車未到站，將到站時間存入gap陣列中，其中接駁車名為鍵名
                $gap[$bus['name']]=abs($bus['minute']-$timer[$station['name']]['arrive']);
            } */
        }
   /*      echo "<pre>";
        print_r($relation);
        echo "</pre>"; */
        //每一部接駁車巡訪完畢後檢視gap陣列中是否有值，及接駁車是否已到站
        //當此站點無已到站的接駁車時，從gap陣列中，取出到站時間最短的接駁車資料
        if(!empty($gap) && $flag==0){
            $min=min($gap);
            $name=array_search($min,$gap); //利用array_search()來找到目標值的鍵值(接駁車名)
            echo $name ;
            echo "約".$min."分鐘";

            //清空gap陣列內容，讓下一個迴圈重新使用$gap這個變數
            $gap=[];

            //重設$flag值為0，讓下一個迴圈重新使用$flag這個變數
            $flag=0;
        }
        


        //顯示此站點名稱
        echo "<div class='point'></div>";
        echo "<div class='bus-info'>";
        foreach($relation as $busname => $min){
            echo $busname.":".$min."<br>";
        }
        echo "</div>";
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
<script>

    $(".point").hover(
        function(){
            $(this).next().show();
        },
        function(){
            $(".block .bus-info").hide();
        }
    )
</script>