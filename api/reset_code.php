<?php
session_start();

//重新產生驗證碼
echo $_SESSION['code']=rand(1000,9999);