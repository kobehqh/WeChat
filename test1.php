<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/24
 * Time: 14:36
 */
$conn = mysqli_connect("localhost", "root", "weicedbmojito160824");   //连接数据库
mysqli_select_db($conn, "hqh");  //选择数据库
mysqli_query($conn, "set names 'utf8mb4'"); //设定字符集
header('content-Type:text/html;charset=uft-8');
date_default_timezone_set('PRC');
session_start();
include 'wx.php';
$obj = new Wx();
$data=$obj->sign();
//$obj->getBaseRight('http://test.lovemojito.com/hqh/WeChat/test1.php');
$userInfo=$obj->getUserInfo();
echo $_SESSION['openid'];
$imgurl=$userInfo['imgurl'];
$openid=$userInfo['openid'];
$nickname=$userInfo['nickname'];

$_SESSION['openid'] =$openid;
$_SESSION['imgurl'] =$imgurl;

$share = $_SESSION['shareOpenid'];
//echo $share;
echo "我".$_SESSION['openid'];
echo '<hr/>';
echo "分享给我的".$share;
$time =date('Y-m-d H:i:s') ;
$sql = "insert into test (shareOpenid,sharedOpenid,imgurl,nickName,createTime) values ('$share','$openid','$imgurl','$nickname','$time')";
$info_insert = mysqli_query($conn, $sql);//添加
$sql1 = "select * from test WHERE shareOpenid='$share'";
$sql2 = "select * from test WHERE sharedOpenid='$openid'";
$result = mysqli_query($conn, $sql1);
$result1 = mysqli_query($conn, $sql2);
if (!$result) {
    printf("Error: %s\n", mysqli_error($result));
    exit();
}
$row = mysqli_fetch_assoc($result);
$row1 = mysqli_fetch_assoc($result1);
echo $row['nickName'];
//echo $row1['nickName'];
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>测试</title>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
<div style="width: 80%;margin: 0 auto">
    <img src="<?php echo $_SESSION['imgurl'];?>" style="display: block;height: 10vw;width: 10vw;border-radius: 5vw">
    <div><?php echo $_SESSION['openid'];?></div>
    <div><?php echo $nickname;?></div>
    <div><?php echo $userInfo['sex'];?></div>
    <div><?php echo $userInfo['city'];?></div>
    <div><?php echo $userInfo['province'];?></div>
    <div><?php echo $userInfo['language'];?></div>
    <div><?php echo $userInfo['country'] ?></div>
    <button id="pic" style="width: 40vw;height: 10vw;font-size:3vw"> 点击选择拍照/选择照片</button>
    <div>
        <img src="<?php echo $row['imgurl'] ?>" id="img" alt="">
    </div>

    </hr>
<!--    <img src="--><?php //echo $row1['imgurl'] ?><!--" id="img" alt="">-->
    <div><?php echo $row['nickName'] ?></div>
</div>

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
            link: 'http://test.lovemojito.com/hqh/WeChat/hqhTest.php?openid='+'<?php echo $_SESSION["openid"];?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://test.lovemojito.com/hqh/WeChat/test.png', // 分享图标
            desc: '测试测试测试测试测试测试测试测试测试测试测试测试测试测试', // 分享描述
            success: function () {
                window.location.href='test1.php';
                // 用户点击了分享后执行的回调函数
            }
        });
        wx.onMenuShareTimeline({
            title: '测试', // 分享标题
            link: 'http://test.lovemojito.com/hqh/WeChat/hqhTest.php?openid='+'<?php echo $_SESSION["openid"];?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://test.lovemojito.com/hqh/WeChat/test.png', // 分享图标
            desc: '测试测试测试测试测试测试测试测试测试测试测试测试测试测试', // 分享描述
            success: function () {
                window.location.href='test1.php';
                // 用户点击了分享后执行的回调函数
            }
        });
        $('#pic').click(function(){
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['original','compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album','camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    alert(localIds);
                    $('#img').attr('src',localIds);
                }
            });
        })

    });

</script>
</body>
</html>