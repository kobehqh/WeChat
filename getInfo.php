<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/25
 * Time: 16:27
 */
function getInfo($openid,$imgurl='',$nickname=''){
    $conn = mysqli_connect("localhost", "root", "weicedbmojito160824");   //连接数据库
    mysqli_select_db($conn, "hqh");  //选择数据库
    mysqli_query($conn, "set names 'utf8mb4'"); //设定字符集
    header('content-Type:text/html;charset=uft-8');
    date_default_timezone_set('PRC');
    $openid_sql = "select openid from weixin-userInfo where openid = '$openid'";//选择openid
    $openid_result = mysqli_query($conn,$openid_sql);
    $num = mysqli_num_rows($openid_result);
    if($num){
        $sql = "select imgurl,nickName,openid from test where openid = '$openid'";
        $res_select = mysqli_query($conn, $sql);
        if($res_select){
            $row = mysqli_fetch_assoc($res_select);
            return $row;
        }
    }else{
        $addTime = date('Y-m-d H:i:s') ;
        $info_insert_sql = "insert into weixin-userInfo (openid,imgurl,nickName,addTime) values('$openid','$imgurl','$nickname','$addTime')";
        $result = mysqli_query($conn, $info_insert_sql);//添加

        $sql = "select imgurl,nickName from weixin-userInfo where openid = '$openid'";
        $res_select = mysqli_query($conn, $sql);

        if($res_select){
            $row = mysqli_fetch_assoc($res_select);
            return $row;
        }
    }
}
?>
