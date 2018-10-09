<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/30
 * Time: 21:59
 */







function sendwxTplMsg($touser_openid, array $data, $tamplate_id, $redictUrl) {
    require_once "wx.php";

    $wechart = new Wx(connect_to_db());
    $wechart->sendTplMsg($touser_openid, $tamplate_id, $data, $redictUrl);
}
?>
