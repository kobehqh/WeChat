<?php
session_start();
require_once "../wx.php";
$wx = new wx();
$t = $wx -> shareWX();
$t = json_encode($t);
echo $t;
?>