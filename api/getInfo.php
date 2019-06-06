<?php
// 第一步：先将config.php包含过来
require '../config.php';

$sql = "SELECT p.title,p.feature,p.created,p.content,p.views,p.likes,u.slug,c.`name`,
(select count(*) from comments where post_id = p.id) AS pl
FROM posts AS p
LEFT JOIN users AS u ON p.user_id = u.id
LEFT JOIN categories AS c ON c.id = p.category_id
WHERE c.id != 1
ORDER BY p.created DESC
LIMIT 0,10";

// 执行sql
$res = mysqli_query($link,$sql);
// 需要从结果集将数据取出来
$data = mysqli_fetch_all($res,1);
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