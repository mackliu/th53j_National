<?php include_once "./api/db.php";?>
<?php

//判斷$_SESSION['login']這個變數是否存在
if(!isset($_SESSION['login'])){

    //如果$_SESSION['login']不存在，表示管理者未登入，
    //將使用者導回登入頁
    header("location:login.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-系統管理</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
</head>
<body>
<?php include "header.php";?>
<div class="container mt-5">
    <?php
/*     if(isset($_GET['pos'])){
            $pos=$_GET['pos'];
        }else{
            $pos='bus';
        } */

        /* $pos=(isset($_GET['pos']))?$_GET['pos']:"bus"; */

        $pos=$_GET['pos']??'bus';  //使用三元運算式簡寫來取得網址$_GET的參數內容
    ?>
    <div class="border p-3">
                            <!-- 根據$pos的值來決定導覽按鈕要啟用(active)那個按鈕 -->
        <a class="btn btn-light <?=($pos=='bus')?'active':'';?>" href="?pos=bus">接駁車管理</a>
        <a class="btn btn-light <?=($pos=='station')?'active':'';?>" href="?pos=station">站點管理</a>
    </div>
    
    <?php

        //根據$pos的值來決定要載入那個功能頁面
        switch($pos){
            case "bus":
                include "admin_bus.php";  //載入接駁車管理頁面
            break;
            case "station":
                include "admin_station.php";   //載入站點管理頁面
            break;
        }
    ?>
</div>

<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
<script src="js.js"></script>
</body>
</html>