<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/26
 * Time: 20:14
 */
function save_result($openid,$nickname,$headimgurl,$shared_openid,$shared_nickname,$shared_headimgurl){
    $conn = mysqli_connect("111.231.94.130", "test", "vlinked@1306");   //连接数据库
    mysqli_select_db($conn, "hqh");  //选择数据库
    mysqli_query($conn, "set names 'utf8mb4'"); //设定字符集
    if(!$conn){
        die("数据库连接失败！");
    }
    $intime= time();
    $sql = "insert into weixinShare (openid,shareOpenid,nickname,shareNickname,imgurl,shareImgurl,creatTime) values ('$shared_openid','$openid','$shared_nickname','$nickname','$shared_headimgurl','$headimgurl','$intime')";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die("写入失败：" . mysqli_error($res));
    }
}
?>
