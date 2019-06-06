<?php 

include '../config.php';

$id = $_POST['id'];

// 构造sql语句
$sql = "SELECT p.title,p.created,p.views,p.likes,p.content,u.nickname,c.`name` FROM posts AS p
LEFT JOIN users AS u ON u.id = p.user_id
LEFT JOIN categories AS c ON c.id = p.category_id
WHERE p.id = {$id}";

// 执行sql语句  
$oneData = getOneData($link,$sql);

$arr = array(
    'code' => 0,
    'msg'  => '查询失败'
);

if($oneData){
    $arr = array(
        'code' => 1,
        'msg'  => '查询成功',
        'data' => $oneData
    );
}

// 最后把数组 以json格式的字符串返回
echo json_encode($arr);