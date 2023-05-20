<?php
include_once "db.php";

$sql="select count(*) from `admin` where `acc`='{$_POST['acc']}' && `pw`='{$_POST['pw']}'";

$chk=$pdo->query($sql)->fetchColumn();

if($chk==1){
    $_SESSION['login']=$_POST['acc'];
    header("location:../admin.php");
}else{
    header("location:../login.php?error=1");
}

