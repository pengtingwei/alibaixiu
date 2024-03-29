<?php include 'public/header.php' ?>
<div class="content">
  <div class="panel hots">
    <h3>热门推荐</h3>
    <ul>
      <li>
        <a href="javascript:;">
          <img src="uploads/hots_2.jpg" alt="">
          <span>星球大战:原力觉醒视频演示 电影票68</span>
        </a>
      </li>
      <li>
        <a href="javascript:;">
          <img src="uploads/hots_3.jpg" alt="">
          <span>你敢骑吗？全球第一辆全功能3D打印摩托车亮相</span>
        </a>
      </li>
      <li>
        <a href="javascript:;">
          <img src="uploads/hots_4.jpg" alt="">
          <span>又现酒窝夹笔盖新技能 城里人是不让人活了！</span>
        </a>
      </li>
      <li>
        <a href="javascript:;">
          <img src="uploads/hots_5.jpg" alt="">
          <span>实在太邪恶！照亮妹纸绝对领域与私处</span>
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="footer">
  <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
</div>
</div>

<script type="text/template" id="nav">
  <div class="article">
    <div class="breadcrumb">
      <dl>
        <dt>当前位置：</dt>
        <dd><a href="javascript:;">{{name}}</a></dd>
        <dd>{{title}}</dd>
      </dl>
    </div>
    <h2 class="title">
      <a href="javascript:;">{{title}}</a>
    </h2>
    <div class="meta">
      <span>{{nickname}} 发布于 {{created}}</span>
      <span>分类: <a href="javascript:;">{{name}}</a></span>
      <span>阅读: ({{views}})</span>
      <span>点赞: ({{likes}})</span>
    </div>
    <div class="content-detail">{{content}}</div>
  </div>
</script>

<script>
  // 判断location.href这个字符串是否包含?id 
  if (location.href.indexOf('?id') == -1) {
    location.href = "index.php";
  }
  // 发起ajax请求 
  $.ajax({
    type: 'post',
    url: 'api/getDetailPost.php',
    data: {
      id: location.href.split('=')[1]
    },
    dataType: 'json',
    success: function(res) {
      if (res.code == 1) {
        // 调用模板的template方法 
        var str = template('nav', res.data);
        // 把str添加到.hots的前面 before这个方法 jQuery 
        $('.hots').before(str);
      }
    }
  });
</script>
</body>

</html>