<?php
session_start();
require_once "../wx.php";
$wx = new wx();
$t = $wx -> shareWX();
//echo "哟吼，请重新登陆噢";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信分享测试</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="css/reset.css"/>
    <script src="js/responsive.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
<div>
    测试测试~
</div>
<script>
    wx.config({
        debug: true,
        appId: '<?php echo $t["appId"];?>',
        timestamp: <?php echo $t["timestamp"];?>,
        nonceStr: '<?php echo $t["nonceStr"];?>',
        signature: '<?php echo $t["signature"];?>',
        jsApiList: [
            'onMenuShareAppMessage',//分享给朋友
            'onMenuShareTimeline',
        ]
    });
</script>
<script>
    wx.ready(function(){
        wx.onMenuShareAppMessage({
            title: '我是分享小测试', // 分享标题
            link: 'http://test.lovemojito.com/wxj/www/wxtest/haoqi_xin/error.php?'+'<?php echo $t["appId"];?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://test.lovemojito.com/wxj/www/wxtest/haoqi_xin/img/mom1.png', // 分享图标
            desc: '我的分享小测试啦！', // 分享描述
            success: function () {
                alert("分享成功！");
                // 用户点击了分享后执行的回调函数
            }
        });
        wx.onMenuShareTimeline({
            title: '我是分享到朋友圈的小测试', // 分享标题
            link: 'http://test.lovemojito.com/wxj/www/wxtest/haoqi_xin/error.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://test.lovemojito.com/wxj/www/wxtest/haoqi_xin/img/mom1.png', // 分享图标
            success: function () {
                alert("分享朋友圈成功！");
            }// 用户点击了分享后执行的回调函数
        });
    });
</script>
</body>
</html>
