<?php
include_once "db.php";

if($_POST['code']!=$_SESSION['code']){
    header("location:../login.php?error=2");
    exit();
}




$sql="select count(*) from `admin` where `acc`='{$_POST['acc']}' && `pw`='{$_POST['pw']}'";

$chk=$pdo->query($sql)->fetchColumn();

if($chk==1){

    //如果帳密正確，則建立一個$_SESSION['login']變數來做為登入的依據
    $_SESSION['login']=$_POST['acc'];

    //如果登入成功，則將使用者導向後台頁面
    header("location:../admin.php");
}else{
    //如果登入失敗，則將使用者導向登入頁面，並在網址上加入錯誤碼
    header("location:../login.php?error=1");
}

