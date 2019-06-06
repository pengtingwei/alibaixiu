<?php 

$arr = array(
    'name' => '张三',
    'age' => 18
);

// 把原数组的下标取出来 生成一个新的索引数据 
// $demo01 = array_keys($arr);
// $v = array_values($arr);
// var_dump($demo01,$v);

// explore()  将一个字符串分割为数组  split()

//implore()  将一个数组 合并为字符串   join()

$str = join('--->',$arr);

echo $str;