<?php
//require_once "wx.php";
//$wx = new wx();
//$wx->getBaseRight();
session_start();
require_once "wx.php";
$wx = new wx();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";//被分享的链接
$url1 = "http://test.lovemojito.com/wxj/www/qixi/login.php";//未被分享的链接

//判断分享与被分享
if ($url != $url1){                  //被分享，跳转至PK页面上传照片
    $string_arr = explode("openid=", $url );
    $string = explode("&from",$string_arr[1]);
    $openid = $string[0];
    $_SESSION['test'] = "已分享";
//    header("location:testfenxiang.php");
    echo $openid;
}else{                  //未分享，跳转至首页
    $_SESSION['test'] = "未分享";
    $wx->getBaseRight("http://test.lovemojito.com/wxj/www/qixi/index.php");
}
?>