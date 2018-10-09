<?php
session_start();
require_once "wx.php";
$wx = new Wx();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";//被分享的链接
$url2 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php";
//安卓
$url1 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php?from=singlemessage";//未被分享的链接
$url3 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php?from=groupmessage";//来自群分享
$url4 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php?from=timeline";
//苹果
$url5 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php?from=singlemessage&isappinstalled=0";//未被分享的链接
$url6 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php?from=groupmessage&isappinstalled=0";//来自群分享
$url7 = "http://test.lovemojito.com/hqh/WeChat/hqhTest.php?from=timeline&isappinstalled=0";
$isWeixinBrowser = $wx -> isWeixinBrowser();
if ($isWeixinBrowser == 1){//为微信浏览器
    if ($url == $url1 || $url == $url2 || $url == $url3 || $url == $url4 || $url == $url5 || $url == $url6 || $url == $url7){       //非被分享者
        $wx->getBaseRight("http://test.lovemojito.com/hqh/WeChat/index.php");//跳转至首页
        $_SESSION['shareOpenid'] = null;

    }else{         //被分享
        $string_arr = explode("openid=", $url );
        $string = explode("&from",$string_arr[1]);
        $openid = $string[0];
        $_SESSION['shareOpenid'] = $openid;//此为分享者的openid

        $wx-> getBaseRight("http://test.lovemojito.com/hqh/WeChat/test1.php");
    }
}else{
//    echo "<h1>请从微信手机端访问，参与活动哦~</h1>";
    $openid = 'oesYL0-f3R4oHUWLW0L9UbIp7JEY';
}
?>