<?php
// 定义一个些常量 用于保存数据库的相关信息

define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PWD','root');
define('DB_NAME','bx');

$link = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

if(!$link){
    die("数据库连接失败");
}

/**
 * 该函数的主要功能是返回多条语句
 * @param $link 对象 连接数据库 产生的连接标识
 * @param $sql 字符串 sql语句
 * @return 二维数组
 */
function getAllData($link,$sql){
    // 执行sql语句
    $res = mysqli_query($link,$sql);
    // 从结果集中取数据
    $data = mysqli_fetch_all($res,1);
    return $data;
}

/**
 * 该函数的主要功能是返回一条语句
 * @param $link 对象 连接数据库 产生的连接标识
 * @param $sql 字符串 sql语句
 * @return 一维数组
 */
function getOneData($link,$sql){
    // 执行sql语句
    $res = mysqli_query($link,$sql);
    // 从结果集中取数据
    $data = mysqli_fetch_assoc($res);
    return $data;
}
