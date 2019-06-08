<?php

// 第一步：导入config.php
include '../../config.php';

$id = $_POST['id'];
// 将数组转换为字符串 
$str = join(',', $id);


$sql = "DELETE FROM categories WHERE id in(" . $str . ")";
// 增删改 mysqli_query 得到是 true|false 查询语句 得到提结果集 
$res = mysqli_query($link, $sql);

$arr = array(
    'code' => 0,
    'msg' => '删除失败'
);

if ($res) {
    $arr['code'] = 1;
    $arr['msg'] = '删除成功';
}

echo json_encode($arr);
