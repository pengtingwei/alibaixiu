<?php 
// 第一步：先引入 config.php文件 
include '../../config.php';

// 第二步：需要接收用户传递过来的数据 
$name = $_POST['name'];
$slug = $_POST['slug'];
$className = $_POST['classname'];
$id = $_POST['id'];

//构建sql语句  
$sql = "UPDATE categories SET name='{$name}',slug = '{$slug}',classname = '{$className}' WHERE id=".$id;
// 执行sql语句 
$res = mysqli_query($link,$sql);

$arr = array(
    'code' => 0,
    'msg' => '更新失败'
);

if($res){
    $arr = array(
        'code' => 1,
        'msg' => '更新成功'
    );
}

echo json_encode($arr);