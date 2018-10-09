<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/30
 * Time: 0:16
 */
$conn = mysqli_connect("localhost", "root", "weicedbmojito160824");   //连接数据库
mysqli_select_db($conn, "hqh");  //选择数据库
mysqli_query($conn, "set names 'utf8mb4'"); //设定字符集
header('content-Type:text/html;charset=uft-8');
date_default_timezone_set('PRC');
?>
