<?php
require_once "wx.php";
$wx = new wx();
$openid =$wx ->getUserInfo();
echo "php";
echo "<hr/>";
echo $openid;
//$conn = mysqli_connect("localhost", "root", "dxx1996");   //连接数据库
//mysqli_select_db($conn, "wxj");  //选择数据库
//mysqli_query($conn, "set names 'utf8'"); //设定字符集
//$sql_insert = "insert into wxtest (openid) values ('$openid')";
//$result = mysqli_query($conn, $sql_insert);    //执行SQL语句
//echo $conn;
//echo $openid;
//$openid = getUserInfo();
//echo $openid;
//function getUserInfo(){
//    $openid = "hello";
////    echo $openid;
//    return $openid;
//}
?>