<?php 

// 第一步：先引入 config.php文件 
include '../../config.php';

// 第二步：需要接收用户传递过来的数据 
$name = $_POST['name'];
$slug = $_POST['slug'];
$className = $_POST['classname'];

// 第三步：先判断该分类的名称是否已经在表里面存在 
$sql = "select count(*) as count from categories where name = '{$name}'";

// 第四步：执行sql语句 
$oneDate = getOneData($link,$sql);

$arr = array(
    'code' => 0,
    'msg' => '查询失败'
);

if($oneDate['count'] > 0){
    $arr['msg'] = "该分类名称已经存在，请更换";
}else{
    // 没有添加  ？？？
    $insertSql = "INSERT INTO categories SET name = '{$name}',slug = '{$slug}',classname = '{$className}'";
    // 执行sql语句  mysqli_query()
    $data = mysqli_query($link,$insertSql);
    
    // 返回前台的时候 只是告诉前面这条数据新增成功 但是并没有告诉前台到底是哪条数据插入成功   我们需要将这条新增数据的ID取出来 返回给前台  
    $id = mysqli_insert_id($link);  

    if($data){
        $arr['code'] = 1;
        $arr['msg'] = '插入成功';
        $arr['id'] = $id;
       
    }

}

echo json_encode($arr);