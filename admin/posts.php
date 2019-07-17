<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>

<body>
  <script>
    NProgress.start()
  </script>

  <div class="main">

    <?php include "public/nav.php"; ?>


    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm" id="category">
            <option value="all">所有分类</option>

          </select>
          <select name="" class="form-control input-sm" id="status">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已作废</option>
          </select>
          <button class="btn btn-default btn-sm" type="button" id="select">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>

  <?php

  // 先给这个页面取一个名字
  $current_page = 'posts';

  include "public/aside.php";



  ?>

  <script src="../assets/vendors/jquery/jquery.min.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/art-template/template.js"></script>
  <script>
    NProgress.done()
  </script>
  <script type="text/template" id="postsAll">
    {{each data as v i}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{v.title}}</td>
      <td>{{v.nickname}}</td>
      <td>{{v.name}}</td>
      <td class="text-center">{{v.created}}</td>
      <td class="text-center">
        {{if v.status == 'drafted'}}
        草稿
        {{else if v.status == 'published'}}
          已发布
          {{else}}
            已作废
            {{/if}}
      </td>
      <td class="text-center">
        <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>

  <!-- 给所有分类来使用 -->
  <script type="text/template" id="categoryBox">
    {{each data as v k}}
    <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>


  <script>
    // 定义一个变量保存当前是第几页

    var currentPage = 1; // 当前页码  
    var pageSize = 50; // 每一页显示多少条数据 

    var totalPage; // 总页数  

    function showPage() {
        console.log(totalPage);
      // 每一个页要显示多少条数 

      var start;
      var end;
      // 让下面的for循环动起来
      if (totalPage > 5) {
        start = currentPage - 2;
        end = currentPage + 2;


        if (currentPage < 3) {
          start = 1;
          end = start + 4;
        }

        // 总共有11页  如果当前页是11    start = totalPage-4   end = totalPage
        // 总共有10页  如果当前页是10    start = totalPage-4   end = totalPage
        // 总共有9页  如果当前页是10    start = totalPage-4   end = 11
        // 总共有8页  如果当前页是10    start = totalPage-4   end = 11

        if (currentPage > totalPage - 3) {
          start = totalPage - 4;
          end = totalPage;
        }


      } else {
        start = 1;
        end = totalPage;
      }



      var str = "";
      // 当前页不等于1 就让它显示 
      if (currentPage != 1) {
        str += '<li data-page="' + (currentPage - 1) + '"><a href="javascript:;">上一页</a></li>';
      }

      for (var i = start; i <= end; i++) {
        if (currentPage == i) {
          str += '<li class="item active" data-page=' + i + '><a href="javascript:;">' + i + '</a></li>';
        } else {
          str += '<li  data-page=' + i + '><a href="javascript:;">' + i + '</a></li>';
        }

      }
      if (currentPage != totalPage) {
        str += '<li data-page="' + (currentPage + 1) + '"><a href="javascript:;">下一页</a></li>';
      }


      $(".pagination").html(str);

    }

    // 将所有的文章取出来渲染到当前页面
    function render(num) {
      $.ajax({
        type: 'post',
        url: "api/getPosts.php",
        data: {
          currentPage: num || 1,
          pageSize: pageSize,
          cid: $('#category').val(),
          status: $('#status').val()
        },
        dataType: 'json',
        success: function(res) {
          if (res.code == 1) {

            totalPage = res.totalPage;

            showPage();

            var str = template("postsAll", res);
            $('tbody').html(str);
          }
        }
      });
    }

    render();

    // 应该给li注册 点击事件  
    $(".pagination").on("click", 'li', function() {
      // 将字符串转换为数值 
      var dataPage = parseInt($(this).attr("data-page"));
      console.log(currentPage);
      // 得到dataPage 需要向服务器发起请求
      currentPage = dataPage;
      render(dataPage);
    });

    // 发起ajax请求获取所有的分类 
    $.ajax({
      type: 'post',
      url: 'api/getCategoies.php',
      dataType: 'json',
      success: function(res) {
        if (res.code == 1) {
          // 将数据渲染到下拉列表中 通过模板引擎将数据进行渲染
          var str = template("categoryBox", res);
          $("#category").append(str);


        }
      }
    });

    // 给筛选按钮注册点击事件 向getPosts.php这个文件发起请求 
    $("#select").on("click", function() {
      currentPage = 1;
      var cid = $("#category").val(); // 获取选择以后分类的ID
      var status = $("#status").val(); // 获取选择的状态 
      // 发送ajax
      $.ajax({
        type: 'post',
        url: 'api/getPosts.php',
        data: {
          currentPage: currentPage,
          pageSize: pageSize,
          cid: cid,
          status: status
        },
        dataType: 'json',
        success: function(res) {
          if (res.code == 1) {
            // 得数据渲染到模板引擎  
            totalPage = res.totalPage;
            console.log(totalPage);
            showPage();

            var str = template("postsAll", res);
            $('tbody').html(str);
          } else {
            $('tbody').html("");
            // $('.pagination').remove();
          }
        }
      });
    });
  </script>
</body>

</html>