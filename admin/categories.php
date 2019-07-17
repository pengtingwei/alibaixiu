<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="msg">发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">

            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="类名">

            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="button" id="add">添加</button>
              <button style="display:none;" class="btn btn-primary " type="button" id="edit">编辑完成</button>
              <button style="display:none;" class="btn btn-primary " type="button" id="quxiao">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td>className</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php

  $current_page = "categories";

  include 'public/aside.php';

  ?>

  <script src="../assets/vendors/jquery/jquery.min.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/art-template/template.js"></script>

  <script type="text/template" id="nav">
    {{each data as v i}}
    <tr id="cid_{{v.id}}">
      <td class="text-center"><input type="checkbox"></td>
      <td>{{v.name}}</td>
      <td>{{v.slug}}</td>
      <td>{{v.classname}}</td>
      <td class="text-center" data-id="{{v.id}}">
        <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
      </td>
    </tr>

    {{/each}}
  </script>

  <script>
    NProgress.done()
  </script>
  <script>
    // 发送ajax给服务器端 
    $.ajax({
      type: 'post',
      url: 'api/getCategoies.php',
      dataType: 'json',
      success: function(res) {
        if (res.code == 1) {
          var str = template('nav', res);
          $('tbody').html(str);
        }
      }
    });


    // 先给这个添加按钮注册点击事件 
    $("#add").on("click", function() {
      // 需要对表单里面的数据进行验证 *****
      var name = $('#name').val();
      var slug = $('#slug').val();
      var classname = $("#classname").val();
      $.ajax({
        type: 'post',
        url: 'api/addCategory.php',
        data: $("form").serialize(),
        dataType: 'json',
        success: function(res) {
          // console.log(res);
          if (res.code == 1) {
            var str = ' <tr id="cid_' + res.id + '">\
                <td class="text-center"><input type="checkbox"></td>\
                <td>' + name + '</td>\
                <td>' + slug + '</td>\
                <td>' + classname + '</td>\
                <td class="text-center" data-id=' + res.id + '>\
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>\
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>\
                </td>\
              </tr>';

            $('tbody').append(str);
            $('#name').val("");
            $('#slug').val('');
            $("#classname").val("");


          } else {
            $('.alert-danger').show();
            $("#msg").text(res.msg);
          }
        }

      });
    });

    // 先给每一个编辑按钮注册一个点击事件
    $('tbody').on('click', '.edit', function() {
      // 当鼠标点击“编辑”按钮时 获取其父元素身上的data-id属性的值  同时给form标签中的id=edit这个按钮 增加一个属性 data-cid 

      var data_id = $(this).parent().attr("data-id");
      $("#edit").attr("data-cid", data_id);
      // 当鼠标点击编辑按钮时 需要将表单里面的添加按钮隐藏 同时 将编辑完成与编辑取消显示出来 
      $("#add").hide();
      $("#edit").show();
      $("#quxiao").show();

      // 当鼠标点击编辑按钮时 需要找到tr标签  然后再找到它里面的孩子 
      $("#name").val($(this).parents('tr').children().eq(1).text());
      $("#slug").val($(this).parents('tr').children().eq(2).text());
      $("#classname").val($(this).parents('tr').children().eq(3).text());

    });

    // 需要给编辑完成按钮 注册点击事件 并且发送ajax请求给后台 
    $('#edit').on('click', function() {
      var name = $("#name").val();
      var slug = $("#slug").val();
      var classname = $("#classname").val();


      var cid = $(this).attr("data-cid");
      // 发送ajax请求给后台
      $.ajax({
        type: 'post',
        url: 'api/updateCategories.php',
        data: {
          name: name,
          slug: slug,
          classname: classname,
          id: cid
        },
        dataType: 'json',
        success: function(res) {
          if (res.code == 1) {
            //先将 添加按钮 显示出来  同时将编辑完成 与取消编辑隐藏  
            $("#add").show();
            $("#edit").hide();
            $("#quxiao").hide();
            // 我们在编辑完成的按钮上面 保存了一个data-cid的值  
            var str = 'cid_' + cid;
            $('#' + str).children().eq(1).text(name);
            $('#' + str).children().eq(2).text(slug);
            $('#' + str).children().eq(3).text(classname);

            // 更新完成 以后 将数据清空 
            $("#name").val("");
            $("#slug").val("");
            $("#classname").val("");
          }
        }
      });

    });

    // 给每一个删除按钮添加点击事件
    $('tbody').on('click', '.del', function() {
      if (window.confirm("确定要删除吗?")) {
        var id = $(this).parent().attr('data-id');

        $.ajax({
          type: 'post',
          url: 'api/delCategory.php',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(res) {
            if (res.code == 1) {
              $('#cid_' + id).remove();
            }
          }
        });

      }

    });

    // 给thead下面的复选框 注册点击事件 
    $("thead input").on('click', function() {
      $('tbody input').prop('checked', $(this).prop('checked'));
      // 如果上面的复选框是打上勾的 需要显示批量删除的按钮 
      if ($(this).prop('checked')) {
        $("#delAll").show();
      } else {
        $("#delAll").hide();
      }

    });

    // 先给下面的所有的复选框注册点击事件  判断被选中的个数 如果被选中的个数等于 下面复选框的个数 就表示全部选中 上面的复选框 也要跟着打勾 

    $("tbody").on("click", 'input', function() {
      // 选中个数 
      var all = $("tbody input:checked").size();
      // 下面所有的复选框的个数 
      var allInputSize = $('tbody input').size();

      $("thead input").prop('checked', all == allInputSize);
      // 如果下面的复选框有两个以上打上勾 选中的个数 要显示批量删除的按钮
      if (all >= 2) {
        $("#delAll").show();
      } else {
        $("#delAll").hide();
      }
    });

    // 需要给批量删除的按钮添加点击事件 
    $('#delAll').on("click", function() {
      if (window.confirm("你确定要删除吗?")) {
        // 定义一个空数组
        var ids = [];
        // 获取被选中的复选框 
        var check = $("tbody :checked");
        // 遍历伪数组 
        check.each(function(index, item) {
          // 取 出id值 
          var id = $(item).parents('tr').children().eq(4).attr("data-id");
          // 把id属性值push到ids这个数组中
          ids.push(id);
        });
        // 发送ajax 让后台将数据给删除 
        $.ajax({
          type:'post',
          url:'api/delAllCategory.php',
          data:{id:ids},
          dataType:'json',
          success:function(res){
            if(res.code == 1){
              check.parents('tr').remove();
            }
          }
        });
      }
    });
  </script>
</body>

</html>