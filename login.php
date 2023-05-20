<?php include_once "./api/db.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-管理員登入</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
</head>
<body>
<?php include "header.php";?>
<div class="container">
    <h1 class="text-center">網站管理-登入</h1>
    <form action="./api/login.php" method="post">
    <?php 
        if(isset($_GET['error'])){
            echo "<div class='text-danger text-center my-3'>帳號或密碼錯誤</div>";
        }


    ?>
    <div class="row w-200">
        <label for="" class="col-2">帳號</label>   
        <input  type="text" name="acc" id="acc" class='form-group form-control col-10'>
    </div>
    <div class="row w-full">
        <label for="" class="col-2">密碼</label>   
        <input  type="password" name="pw" id="pw" class='form-group form-control col-10'>
    </div>
    <div class="row w-full">
        <label for="" class="col-2">驗證碼</label>   
        <input  type="text" name="code" id="code" class='form-group form-control col-10'>
    </div>
    <div class="row w-full justify-content-end">
        <div class="btn btn-primary m-2">2132</div>
        <div class="btn btn-dark m-2">重新產生驗證碼</div>
    </div>
    <div class="row w-full">
        <input  type="submit" value="登入" class='col-12 btn btn-success '>
    </div>

    </form>
</div>


<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>