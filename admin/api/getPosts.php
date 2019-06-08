<?php

// 第一步：先引入 config.php文件 
include '../../config.php';

$currenPage = $_POST['currentPage'];
$pageSize = $_POST['pageSize'];
$cid = $_POST['cid']; // 分类的id
$status = $_POST['status']; // 状态 

$offset = ($currenPage - 1) * $pageSize;


$where = " WHERE 1 ";

// 如果没有点击筛选 或者是选择是所有的分类 和所有的状态  表示它们的 $cid = all 和$status = all  只要当这两个变量的值 不是all的时候 就表示 需要 进行筛选   
if($cid != 'all'){
    $where .= " AND c.id =".$cid;
}

if($status != 'all'){
    $where .= " AND p.status ='{$status}' ";
}


// 构建 sql语句 
$sql = "SELECT p.title,p.created,p.`status`,u.nickname,c.`name` FROM posts AS p
LEFT JOIN users AS u ON u.id = p.user_id
LEFT JOIN categories AS c ON p.category_id = c.id
".$where."
limit {$offset},{$pageSize}
";

// echo $sql;


// 执行sql
$data = getAllData($link, $sql);

// $oneSql = "select count(*) as c from posts";
$oneSql = "SELECT count(*) as c FROM posts AS p
LEFT JOIN users AS u ON u.id = p.user_id
LEFT JOIN categories AS c ON p.category_id = c.id
".$where."";
$oneDate = getOneData($link,$oneSql);
// var_dump($oneDate);
$arr = array(
    'code' => 0,
    'msg' => '查询失败'
);

if ($data) {
    $arr = array(
        'code' => 1,
        'msg' => '查询成功',
        'data' => $data,
        'totalPage' => ceil($oneDate['c']  / $pageSize)
    );
}

echo json_encode($arr);
