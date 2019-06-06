<?php include 'public/header.php' ?>
<div class="content">
    <div class="panel new">


    </div>

    <!-- 新增div 行内元素与行内块元素在一个父盒子要居中 可以使用text-align:center-->
    <div class="loadMore text-center">
        <button class="btn btn-success btn-lg">点击加载更多</button>
    </div>

</div>
<div class="footer">
    <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
</div>
</div>
<script type="text/template" id="info">
    <h3>{{data[0].name}}</h3>
    {{each data as v i}}
    <div class="entry">
        <div class="head">
            <span class="sort">{{v.name}}</span>
            <a href="detail.php?id={{v.id}}">{{v.title}}</a>
        </div>
        <div class="main">
            <p class="info">{{v.slug}} 发表于 {{v.created}}</p>
            <p class="brief">{{v.content}}</p>
            <p class="extra">
                <span class="reading">阅读({{v.views}})</span>
                <span class="comment">评论({{v.pl}})</span>
                <a href="javascript:;" class="like">
                    <i class="fa fa-thumbs-up"></i>
                    <span>赞({{v.likes}})</span>
                </a>
                <a href="javascript:;" class="tags">
                    分类：<span>{{v.name}}</span>
                </a>
            </p>
            <a href="javascript:;" class="thumb">
                <img src="{{v.feature}}" alt="">
            </a>
        </div>
    </div>

    {{/each}}

</script>


<script type="text/template" id="infoMore">
    {{each data as v i}}
    <div class="entry">
        <div class="head">
            <span class="sort">{{v.name}}</span>
            <a href="detail.php?id={{v.id}}">{{v.title}}</a>
        </div>
        <div class="main">
            <p class="info">{{v.slug}} 发表于 {{v.created}}</p>
            <p class="brief">{{v.content}}</p>
            <p class="extra">
                <span class="reading">阅读({{v.views}})</span>
                <span class="comment">评论({{v.pl}})</span>
                <a href="javascript:;" class="like">
                    <i class="fa fa-thumbs-up"></i>
                    <span>赞({{v.likes}})</span>
                </a>
                <a href="javascript:;" class="tags">
                    分类：<span>{{v.name}}</span>
                </a>
            </p>
            <a href="javascript:;" class="thumb">
                <img src="{{v.feature}}" alt="">
            </a>
        </div>
    </div>

    {{/each}}

</script>

<script>
    // 判断地址栏上面的数据 是否有list.php?id=10
    if (location.href.indexOf('cid') == -1) {
        location.href = "index.php";
    }
    // 从地址栏中将cid的值取出来
    var cid = location.href.split('=')[1];
    // 请求分类导航功能 
    $.ajax({
        type: 'get',
        url: 'api/getCid.php',
        data: {
            id: cid
        },
        dataType: 'json',
        success: function(res) {

            // 这里一定要判断 res.code的值 是不是等于1 如果等于 1就表示有数据返回
            if (res.code == 1) {
                // 将数据渲染到html页面
                var str = template('info', res);
                $('.new').append(str);
            } else {
                // 查询失败的结果
                location.href = "index.php";
            }
        }

    });

    var count = 1;

    // 实现加载更多的功能 
    $(".loadMore .btn").on("click", function() {
       
        count++;
        $.ajax({
            type: 'post',
            url: 'api/getMorePosts.php',
            data: {
                // 点击的次数  当前的cid 每一次点击需要请求多少条数据
                count: count,
                cid: cid,
                pageSize: 10
            },
            dataType: 'json',
            success: function(res) {
                if (res.code == 1) {
                    console.log(res);
                    

                    var str = template('infoMore', res);

                    $('.new').append(str);

                    // 判断点击的次数是于等于 Math.ceil(总记录数 / pageSize) 

                    var total = Math.ceil(res.totalPage / 10);

                    if (count == total) {
                        // 将div给其隐藏
                        $('.loadMore').hide();
                    }


                }
            }
        });
    });
</script>
</body>

</html>