<?php 

require '../config.php';

// 第一个需要前端传过来的点击次数 
// 第二个：分类ID
// 第三个：加载多少条数据  

$count = $_POST['count'];
$id = $_POST['cid'];
$pageSize = $_POST['pageSize'];


// 如果 当前我们打开页面的时候 先默认已经取了前10  
// 0,10  第一页   (当前页码 - 1) *10 
// 11,10 第二页   
// 21,10 第三页

// select * from 表名  limit 开始下标,要取多少条数据   开始下标是 从0开始  

$offset = ($count - 1) * $pageSize;
// 处理点击加载更多的功能 
$sql = "SELECT p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,u.slug,c.`name`,
(select count(*) from comments where post_id = p.id) AS pl
FROM posts AS p
LEFT JOIN users AS u ON p.user_id = u.id
LEFT JOIN categories AS c ON c.id = p.category_id
WHERE c.id = {$id}
ORDER BY p.created DESC
LIMIT {$offset},{$pageSize}";

// 调用 getAllDate()
$data = getAllData($link,$sql);


// 需要先获取 posts表里面的某个分类的总记录数  需要打开 api/getPostsMore.php文件 
// 需要新增一条SQL 语句 专用于获取某个分类的总记录数

$totalSql = "SELECT count(*) AS c FROM posts WHERE category_id ={$id}";
// getOneData是专用于处理只获取一条数据 的时候 使用 返回是一个一维数组 
$oneDate = getOneData($link,$totalSql);


$arr = array(
    'code' => 0,
    'msg' => '查询失败'
);
if($data){
    $arr = array(
        'code' => 1,
        'msg' => '查询成功',
        'totalPage' => $oneDate['c'],
        'data' => $data
    );
}
echo json_encode($arr);