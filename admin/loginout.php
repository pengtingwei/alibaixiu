<?php 

// 第一步：开启session 
session_start();
// 要清除保存的session 
unset($_SESSION['is_login']);
// 跳转到登录界面 
header("location:login.php");