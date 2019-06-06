<?php

include '../../config.php';

// 接收到发送过来的数据 
$email = $_POST['email'];
$pwd = $_POST['pwd'];

// 验证输入的数据是否合法 
$sql = "SELECT * FROM users WHERE email = '{$email}' and password = '{$pwd}' and  status = 'activated'";

// 执行sql语句  

$data = getOneData($link, $sql);
// var_dump($data);

$arr = array(
    'code' => 0,
    'msg'  => '查询失败'
);

// 判断 $data 
if ($data) {
    // 开始session 
    session_start();
    // 保存登录状态
    $_SESSION['is_login'] = 'yes';
    // 将用户的昵称和头像赋值给$_SESSION['user']和$_SESSION['img']
    $_SESSION['user'] = $data['nickname'];
    $_SESSION['img'] = $data['avatar'];
    

    $arr = array(
        'code' => 1,
        'msg'  => '查询成功'
    );
}

// 以json格式返回给客户端
echo json_encode($arr);