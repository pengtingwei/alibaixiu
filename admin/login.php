<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <!-- 引入jQuery文件 -->
  <script src="../assets/vendors/jquery/jquery.min.js"></script>
</head>

<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display: none;">
        <strong>错误！</strong> <span id="msg">用户名或密码错误！</span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span class="btn btn-primary btn-block">登 录</span>
    </form>
  </div>
  <script>
    $(function () {
      $('.btn-primary').on('click', function () {
        // 需要获取到email与密码
        var email = $("#email").val();
        var pwd = $("#password").val();
        // 验证输入的邮件是否合法   abcd@qq.com.cn
        var reg = /\w+[@]\w+([.]\w+)+/;
        if (!reg.test(email)) {
          $(".alert").fadeIn(1000).delay(1000).fadeOut(1000);
          $("#msg").text("您输入的邮件不合法，请重新输入");
          return;
        }

        // 发送ajax
        $.ajax({
          type: 'post',
          url: 'api/checkUser.php',
          data: {
            email: email,
            pwd: pwd
          },
          dataType: 'json',
          success: function (res) {
            if (res.code == 1) {
              // 如果成功 需要跳转到index.php中
              location.href = "index.php";
            } else {
              $(".alert").fadeIn(1000).delay(1000).fadeOut(1000);
              $("#msg").text("邮件或者密码有误!");

            }

          }
        });

      });

    });


  </script>
</body>

</html>