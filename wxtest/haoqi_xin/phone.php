<?php
session_start();
$phone = $_POST["phone"];
$mark = $_POST["mark"];
//$openid =$wx ->getUserInfo();//用户的openid
$conn = mysqli_connect("121.41.23.82", "root", "weicedbmojito160824");   //连接数据库
mysqli_select_db($conn, "wxj");  //选择数据库
mysqli_query($conn, "set names 'utf8'"); //设定字符集
$sql = "select phoneNumber from phone where phoneNumber = '$_POST[phone]'"; //SQL语句;
$result = mysqli_query($conn, $sql);    //执行SQL语句
$num = mysqli_num_rows($result); //统计执行结果影响的行数
if ($num)    //如果是否彩信用户，是的情况
{
    $mark = "SELECT phoneNumber,mark FROM phone WHERE phoneNumber = '$_POST[phone]'AND mark = '1'";
    $sql_mark = mysqli_query($conn,$mark);
    $num1 = mysqli_num_rows($sql_mark);//判断影响行数
    if($num1){
        $test = array('address'=>'address.php?phone=','phone'=>$_POST["phone"],'used'=>true,'mark'=>$_POST["mark"]);
    }else{
        $sql_insert = "UPDATE phone SET mark = '$_POST[mark]' WHERE phoneNumber = '$_POST[phone]'";//给页面弄了个标志位，在提交的submitBtn里
        $res_insert = mysqli_query($conn, $sql_insert);
        $test = array('used'=>'false');
        $test = array('address'=>'address.php?phone=','phone'=>$_POST["phone"],'used'=>false,'mark'=>$_POST["mark"]);
        if($_POST["mark"]){
            $_SESSION["phone"] = "phone=".$_POST["phone"];
        }
    }
}else    //不是彩信用户
{
    $test = array('address'=>'#');//不跳转
}
$test = json_encode($test,JSON_UNESCAPED_UNICODE);
echo $test;//将test输出
?>