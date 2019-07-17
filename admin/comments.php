<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
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
    <?php include 'public/nav.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
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
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr class="danger">
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>已批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>

  <?php

  $current_page = "comments";

  include 'public/aside.php'

  ?>

  <script src="../assets/vendors/jquery/jquery.min.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/art-template/template.js"></script>
  <!-- 引入分页插件 -->
  <script src="../assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script type="text/template" id="content">
    {{each data as v k}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{v.author}}</td>
      <td>{{v.content}}</td>
      <td>{{v.title}}</td>
      <td>{{v.created}}</td>
      <td>{{v.status}}</td>
      <td class="text-center" data-id="{{v.id}}">
        <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    {{/each}}

  </script>
  <script>
    NProgress.done()
  </script>
  <script>
    var currentPage = 1; // 表示当前页
    var pageSize = 10; //每一页显示多少条数据

    var totalPage;  // 声明变量 
    // 发送ajax
    function render(num) {
      $.ajax({
        type: 'post',
        url: "api/getComments.php",
        data: {
          currentPage: num || 1,
          pageSize: pageSize
        },
        dataType: 'json',
        success: function(res) {
          if (res.code == 1) {
            totalPage = res.totalPage;

            // 需要调用模板引擎来渲染数据  
            // console.log(res);
            var str = template("content", res);
            $('tbody').html(str);

            // 分页插件
            $('.pagination').twbsPagination({
              totalPages: totalPage, // 总页数  
              visiblePages: 5, // 最大分页页码
              onPageClick: function(event, page) {
                render(page);
              }
            });
          }
        }
      });
    }
    render();
  </script>
</body>

</html>