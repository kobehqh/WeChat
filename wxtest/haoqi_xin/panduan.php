<?php
session_start();
require_once "../wx.php";
$wx = new wx();
$openid =$wx ->getUserInfo();
//$_SESSION['openid'] = $openid;//将值存入session中
//if($_SESSION['openid']){//成功获得openid
//    $_SESSION['time'] = time() + 60;
//    header("location:phone_check.php");
//}else{//未成功获得openid
//    header("location:error.php");
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Huggies好奇</title>
</head>
<body>
<img src="<?php echo $openid["imgurl"];?>">
</body>
</html>
