<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 22:54
 */
header('content-Type:text/html;charset=uft-8');
session_start();
require_once 'config.php';
include "wx.php";
$wx = new Wx();
$info =$wx ->getUserInfo();//获得code，以此来获得用户的openid等信息
$data = $wx -> sign();//分享接口
if($info['openid']){
    $_SESSION['openid'] = $info['openid'];
    $_SESSION['sex'] = $info['sex'];
    $_SESSION['imgurl']= $info['imgurl'];
    echo '你好';
//    $fansInfo = getInfo($info['openid'],$info['imgurl'],$info['nickname']);//用户信息
    print_r($info['nickname']);
    $openid = $info['openid'];
    $nickname = $info['nickname'];
    $imgurl = $info['imgurl'];
    echo '<hr/>';
    echo $imgurl;
    $addTime = date('Y-m-d H:i:s') ;

    $result_query = "select openid from test1 where openid = '$openid'";//选择openid
    $result = mysqli_query($conn,$result_query);
    $num = mysqli_num_rows($result);
    if($num){
        $sql = "select imgurl,nickName,openid from test where openid = '$openid'";
        $res_select = mysqli_query($conn, $sql);
        if($res_select){
            $row = mysqli_fetch_assoc($result1);
        }
    }else{
        $result_query1 = "insert into test1 (openid,nickName,addTime,imgurl) values ('$openid','$nickname','$addTime','$imgurl')";
        $result1 = mysqli_query($conn, $result_query1);//添加

        if($result1){
            $row = mysqli_fetch_assoc($result1);
        }else{
            echo '插入失败';
        }
    }

}else{
    echo "咩有";
//    $fansInfo = getInfo($_SESSION['openid']);
}
echo '<hr/>';
echo $_SESSION['openid'];
echo '<hr/>';
//session_start();
//include 'wx.php';
//$obj = new Wx();
//$data=$obj->sign();
//$obj->getBaseRight('http://test.lovemojito.com/hqh/WeChat/test1.php');
//$userInfo=$obj->getUserInfo();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试js-SDK</title>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
<div>我是测试</div>
<img src="<?php echo $_SESSION['imgurl'];?>" id="img">
<img src="<?php echo $row['imgurl'];?>" id="img1">
<!--微信配置-->
<script>
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $data['appId'] ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $data["timestamp"];?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $data['nonceStr'] ?>', // 必填，生成签名的随机串
        signature: '<?php echo $data['signature'] ?>',// 必填，签名
        jsApiList: [
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
            'chooseImage'
        ] // 必填，需要使用的JS接口列表
    });
</script>
<script>
    wx.ready(function(){

        //分享给朋友
        wx.onMenuShareAppMessage({
            title: '测试', // 分享标题
            link: 'http://test.lovemojito.com/hqh/WeChat/hqhTest.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://test.lovemojito.com/hqh/WeChat/test.png', // 分享图标
            desc: '测试测试测试测试测试测试测试测试测试测试测试测试测试测试', // 分享描述
            success: function () {
                window.location.href='test1.php';
                // 用户点击了分享后执行的回调函数
            }
        });
        wx.onMenuShareTimeline({
            title: '测试', // 分享标题
            link:'http://test.lovemojito.com/hqh/WeChat/hqhTest.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://test.lovemojito.com/hqh/WeChat/test.png', // 分享图标
            desc: '测试测试测试测试测试测试测试测试测试测试测试测试测试测试', // 分享描述
            success: function () {
                window.location.href='index.php';
                // 用户点击了分享后执行的回调函数
            }
        });
//        wx.chooseImage({
//            count: 1, // 默认9
//            sizeType: ['original','compressed'], // 可以指定是原图还是压缩图，默认二者都有
//            sourceType: ['album','camera'], // 可以指定来源是相册还是相机，默认二者都有
//            success: function (res) {
//                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
//                alert(localIds);
//                $('#img').attr('src',localIds);
//            }
//        });
    });

</script>
</body>

</html>