
 <div class="aside">
   <div class="profile">
     <img class="avatar" src="<?php echo $_SESSION['img'];?>">
     <h3 class="name"><?php echo $_SESSION['user'] ?></h3>
   </div>
   <ul class="nav">
     <li class="active">
       <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
     </li>
     <?php
        $arr = ['posts', 'post-add', 'categories'];

        // in_array(字符串，数组) 判断这个字符串是否在这个数组里面 如果在 就返回tru　　如果没有就返回false 
        $bool = in_array($current_page, $arr);

        // 如果$bool这个值是true那就说明要展开 如果为false就表示不展开  collapsed

        ?>
     <li class="<?php echo $bool ? 'active' : '';  ?>">


       <a href="#menu-posts" class="<?php echo $bool ? '' : 'collapsed' ?>" data-toggle="collapse" aria-expanded="<?php echo $bool ? 'true' : 'false'  ?>">
         <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
       </a>
       <ul id="menu-posts" class="collapse <?php echo $bool ? 'in' : ''  ?> " aria-expanded="<?php echo $bool ? 'true' : 'false'  ?>">
         <li class="<?php 
          if($current_page === 'posts'){
            echo "active";
          } ?>"><a href="posts.php">所有文章</a></li>
         <li class="<?php 
          if($current_page === 'post-add'){
            echo "active";
          } ?>"><a href="post-add.php">写文章</a></li>
         <li class="<?php 
          if($current_page === 'categories'){
            echo "active";
          } ?>"><a href="categories.php">分类目录</a></li>
       </ul>
     </li>
     <li>
       <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
     </li>
     <li>
       <a href="users.php"><i class="fa fa-users"></i>用户</a>
     </li>
     <li>
       <a href="#menu-settings" class="collapsed" data-toggle="collapse">
         <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
       </a>
       <ul id="menu-settings" class="collapse">
         <li><a href="nav-menus.php">导航菜单</a></li>
         <li><a href="slides.php">图片轮播</a></li>
         <li><a href="settings.php">网站设置</a></li>
       </ul>
     </li>
   </ul>
 </div>
