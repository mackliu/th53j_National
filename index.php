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
        
        .block-top,.block-bottom{
            height:calc( ( 100% - 25px ) / 2); /* */
            display:flex;
            text-align: center;
            padding:5px 0;
        }
        .block-top{
            align-items:flex-end;
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

        /**設定畫直線三個class的共同設定
         * 包含背景顏色及定位方式
         */
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

        /**
         * 彈出視窗: 
         * 預設不顯示，滑鼠移進站點時才顯示
         * 背景設為白色用來遮住底層的資訊,營造彈出視窗在上層的感覺
         * position:absolute為絕對定位，位置為.block中的位置
         * z-index:垂直位置，
         */
        .block .bus-info{
            display:none;
            position:absolute;
            top:1px;
            padding:8px;
            background:white;
            box-shadow:2px 2px 10px #999;
            z-index:100;
            border-radius:5px;

        }

        /**已到站的文字以紅色顯示 */
        .arrive{
            color:red;
        }

        /**未發車的文字以灰色顯示 */
        .nobus{
            color:#666;
        }

        /**站點數量按鈕，做成圓形的 */
        .station-num{
            width:25px;
            height:25px;
            display:inline-flex;
            justify-content:center;
            align-items:center;
            border:1px solid #555;
            border-radius:50%;
            margin:5px;
            cursor: pointer;
        }

        /**使用在站點數量切換上，當前的站點數量會以背景藍，字白的方式呈現 */
        .active{
            background:blue;
            color:white;
            font-weight:bold;
        }
    </style>
</head>
<body>
<?php include "header.php";?>
<div class="d-flex flex-wrap my-4 mx-auto shadow p-5" style="width:min-content">
<div class='w-100'>
    <?php
    //透過網此參數來決定$active的值，預設為3
    if(isset($_GET['p'])){
        $active=$_GET['p'];
    }else{
        $active=3;
    }
    ?>
    <!--建立數個按鈕來代表目前的路網圖是多少站點一排,
        點擊按鈕後，路網圖會根據站點數量做出變化-->
    <div class="station-num <?=($active==1)?'active':'';?>" id="s1" onclick="showStation(1)">1</div>
    <div class="station-num <?=($active==2)?'active':'';?>" id="s2" onclick="showStation(2)">2</div>
    <div class="station-num <?=($active==3)?'active':'';?>" id="s3" onclick="showStation(3)">3</div>
    <div class="station-num <?=($active==4)?'active':'';?>" id="s4" onclick="showStation(4)">4</div>
    <div class="station-num <?=($active==5)?'active':'';?>" id="s5" onclick="showStation(5)">5</div>
</div>
<h1 class='text-center w-100'>接駁車路網圖</h1>
<?php 

//取出所有的站點資料並依照before欄位進行排序
$sql="select * from `station` order by `before`";
$stations=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

//根據網址參數P來決定變數$div的值，此變數用來決定多少站點一橫列
$div=$_GET['p']??3;

//建立一個分組陣列，用來將站點以$div個站點為一組做分組並存入暫存陣列中
$group=[];
foreach($stations as $idx => $station){
    //將站點資料的索引值透過floor($dix/$div)來計算分組
    /**
     * 0 floor(0/3) = 0 => 放入第0組
     * 1 floor(1/3) = 0 => 放入第0組
     * 2 floor(2/3) = 0 => 放入第0組
     * 3 floor(3/3) = 1 => 放入第1組
     * 4 floor(4/3) = 1 => 放入第1組
     * 5 floor(5/3) = 1 => 放入第1組
     */
    $group[floor($idx/$div)][]=$station;
}

//使用迴圈來檢視暫存陣列中每一組站點
foreach($group as $idx => $points){

    //其中索引值為奇數的站點會進行反序的處理
    /**
     * 0 偶數 => 不處理          [1,2,3]
     * 1 奇數 => 陣列中的站點反序 [3,2,1]
     * 2 偶數 => 不處理          [1,2,3] 
     * 3 奇數 => 陣列中的站點反序 [3,2,1]
     * 4 偶數 => 不處理          [1,2,3]
     */
    if($idx%2==1){
        $group[$idx]=array_reverse($points);
    }
}

//$group是站點分組的陣列
//$idx是分組的索引值
//$points則是分組中的站點陣列
foreach($group as $idx => $points){

    //判斷分組陣列中的站點分組索引值為奇數或偶數，給予靠左或靠右的排列css
    if($idx%2==1){
        echo "<div class='d-flex w-100 position-relative justify-content-end'>";
    }else{
        echo "<div class='d-flex w-100 position-relative'>";
    }

    //根據站點總數來判斷是否要加上垂直連接線
    /**
     * 分組數目->count($tmp)
     * 檢查值->分組數目-1 //因為要從0開始算
     */
    $chk=count($group)-1;

    //如果目前的$idx比分組的數目小，表示會有下一個橫列產生
    //那目前$idx這一橫列應該要加上垂直連接線
    if($idx<$chk){

        //判斷分組陣列中的索引值為奇數或偶數，給予垂直連接線靠左或靠右的排列css
        /**
         * 0 奇數 連接線靠右  ---->|
         * 1 偶數 連接線靠左 |<----
         * 2 奇數 連接線靠右  ---->|
         * 3 偶數 連接線靠左 |<----
         */
        if($idx%2==1){
            echo "<div class='connect connect-left'></div>";
        }else{
            echo "<div class='connect connect-right'></div>";
        }
    }

    //將分組中的各個站點列出並進行顯示相關的處理，主要是用來決定要畫那種線
    foreach($points as $num => $station){

        //如果為起始站，則只畫右邊線
        //起始站的定義是 分組($idx)為第一組 而且 在第一組中的第一站(索引為0)
        if($idx==0 && $num==0 ){
            echo "<div class='block right'>";

            //如果為最後一站，需進一步判斷是那一個方向的最後一站
            //最後一組的判斷法是$group中的最後一個元素(組) count($group)-1
        }else if($idx==(count($group)-1)){
            
            //找出最後一組後接著是根據向右或向左靠來找出分組陣列中的最後一個值
            //判斷分組索引值為偶數，而且站點為目前分組的最後一個
            if($idx%2==0 && ($num==count($points)-1)){
                
                    //只需畫左邊的線
                    echo "<div class='block left'>";

            //判斷分組索引值為奇數，而且站點為目前分組的第一個
            }else if($idx%2==1 && $num==0){
            
                    //只需畫右邊的線
                    echo "<div class='block right'>";
            }else{

                echo "<div class='block line'>";
            }
        }else{
            echo "<div class='block line'>";
        }

        //利用get_station來取得目前站點的接駁車資訊
        $station_buses=get_station($station['id']);

        //status的值和class名一樣，用來決定不同狀態的文字顏色
        echo "<div class='block-top {$station_buses['buses'][0]['status']}'>";

        if($station['before']==0 && $station_buses['buses'][0]['status']=='passed'){
            //針對首站的狀況特殊處理，如果首站沒有任何已到站的車，則顯示未發車
            echo "<span style='color:gray'>未發車</span>";
        }else{

            //除了未發車的狀況，其他的站點都是顯示陣列中的第一輛接駁車的資訊
            echo $station_buses['buses'][0]['name'];
            echo "<br>";
            echo $station_buses['buses'][0]['show'];
        }
        echo "</div>";

        //顯示站點圈圈
        echo "<div class='point'></div>";

        //建立一個容器用來放三輛接駁車資訊,並做成彈出視窗顯示，
        //此容器預設為不顯示(display:none)
        echo "<div class='bus-info'>";
     
        //使用for迴圈來顯示三筆資料
        for($i=0;$i<3;$i++){
            
            //判斷是否有此接駁車的資料
            if(isset($station_buses['buses'][$i])){

                if($station_buses['buses'][$i]['status']=='arrive'){

                    //已到站的車以紅字顯示
                    echo "<div class='arrive'>";
                }else{
                    echo "<div>";
                }
                echo $station_buses['buses'][$i]['name'].": ".$station_buses['buses'][$i]['show'];
                echo "</div>";
            }
        }
        echo "</div>";

        //顯示站點名稱
        echo "<div class='block-bottom'>{$station['name']}</div>";
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
    //當滑鼠移到站點圈圈上時，顯示接駁車資訊彈出視窗
    $(".point").hover(
        function(){
            $(this).next().show();      
        },
        //當滑鼠移出站點圈圈時，隱藏接駁車資訊彈出視窗
        function(){
            $(".block .bus-info").hide();
        }
    )

    //在點擊按鈕時重整頁面並且帶入一個站點數字。
    function showStation(num){
        location.href='?p='+num;
    }

</script>