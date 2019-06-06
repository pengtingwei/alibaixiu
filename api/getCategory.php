<?php
// 第一步：先将config.php包含过来
require '../config.php';
// 构建sql语句
//$sql = "SELECT * FROM a";
$sql = "SELECT * FROM categories WHERE id !=1 ";
//var_dump($sql);
// 执行sql
$res = mysqli_query($link,$sql);
// 需要从结果集将数据取出来
// 第二个参数 共有三个数字来表示  1 表示以关联数组返回  数字 2 表示以索引数组返回  数字3 关联和索引都有
$data = mysqli_fetch_all($res,1);
// 用于向前端返回信息  code为0就表示查询失败
$arr = array(
    'code' => 0,
    'msg' => '查询失败'
);
if($data){
    $arr = array(
        'code' => 1,
        'msg' => '查询成功',
        'data' => $data
    );
}
echo json_encode($arr);
