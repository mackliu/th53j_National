<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-管理登入</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">    
</head>
<body>
<?php include "header.php";?>

<h1 class="text-center">網站管理-登入</h1>
<form action="./api/login.php" class="form-group col-6 m-auto" method="post">
    <?php
        if(isset($_GET['error'])){
            echo "<div class='text-center text-danger'>帳號或密碼錯誤</div>";
        }
    ?>
    <div class="form-group row">
        <label for="" class="col-2 col-form-label">帳號：</label>
        <input type="text" name='acc' class="col-10 form-control">
    </div>
    <div class="form-group row">
        <label for="" class="col-2 col-form-label">密碼：</label>
        <input type="text" name='pw' class="col-10 form-control">
    </div>
    <div class="form-group row">
        <label for="" class="col-2 col-form-label">驗證碼：</label>
        <input type="text" name='code' class="col-10 form-control">
    </div>
    <div class='form-group row justify-content-end'>
        <div class="border p-2 bg-primary text-white">6819</div>
        <button class='btn btn-secondary'>重新產生驗證碼</button>
    </div>
    <div class="form-group row">
        <input type="submit" class="col-12 form-control btn btn-success" value="登入">
    </div>
    
</form>    


<script src="./jquery-3.7.0.min.js"></script>
<script src="./bootstrap/bootstrap.js"></script>    
</body>
</html>