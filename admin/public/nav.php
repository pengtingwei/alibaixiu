<?php
  // 判断是否有登录状态 如果没有 就让它回到登录页面
  session_start();
  if(!(isset($_SESSION['is_login']) && $_SESSION['is_login'] == 'yes')){

    // 表示没有登录  
    header("location:login.php");
  }



?>


<nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="loginout.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
</nav>
