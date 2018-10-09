<?php
class wx
{
    //创建连接
    public function connect($url,$type = 'get',$res = 'json',$arr = ''){
        $ch = curl_init();//初始化curl
        //设置curl参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);//超时时间
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //进行配置
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //进行配置
        if($type == "post"){
            curl_setopt($ch,CURLOPT_POST,1);//为post请求
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        $outopt = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);//错误信息要在关闭前得到
        curl_close($ch);
        $jsoninfo = json_decode($outopt, true);//解码接口数据，将json格式字符串转换成php变量或数组。默认是变量，加true后是数组。
        if ($curl_errno > 0) {
            echo $curl_errno;
            echo $curl_error;//失败时返回错误原因
        } else {
            return $jsoninfo;
        }
    }

    //获得access_token,存放在session中
    public function normal_access_token(){
        $appid = 'wx2f594289390a8112';
        $appsecret = '22efd41cfccbfec32bb8d6d8863d2d19';
        if($_SESSION['access_token'] && $_SESSION['expire_time'] > time()){
            return $_SESSION['access_token'];
        }else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";//接口调用地址
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);//与url建立对话,设置要抓取的url
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//进行配置,将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);//超时时间
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //进行配置
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //进行配置
            $output = curl_exec($ch);//执行对话，获取接口数据Access Token
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);//关闭会话
            $jsoninfo = json_decode($output, true);//解码接口数据，将json格式字符串转换成php变量或数组。默认是变量，加true后是数组。将结果专为json格式
            $access_token = $jsoninfo["access_token"];
            if ($curl_errno > 0) {
                echo $curl_errno;
                echo $curl_error;//失败时返回错误原因
            } else {
                $_SESSION['access_token'] = $access_token;
                $_SESSION['expire_time'] = time() + 7200;
                return $access_token;
            };
        }
    }
    //创建自定义菜单
    public function creatMenu(){
        $access_token = $this->normal_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $postArr = array(
            'button'=>array(            //第一个一级菜单
                array(
                    'type'=>'click',
                    'name'=>urlencode('1'),
                    'key' =>'Item1'
                ),            //第二个一级菜单
                array(
                    'name' => urlencode('2'),
                    'sub_button' =>array(//三个二级菜单
                        array(
                            'type'=>'view',
                            'name'=>urlencode('test'),
                            'url' =>'http://test.lovemojito.com/wxj/www/wxtest/login.php'
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode('22'),
                            'url' =>'http://test.lovemojito.com/wxj/www/wxtest/test.html'
                        ),
                        array(
                            'type'=>'click',
                            'name'=>urlencode('23'),
                            'key' =>'Item2'
                        ),
                    ),
                ),//第三个一级菜单
                 array(
                     'type'=>'click',
                     'name'=>urlencode('3'),
                     'key' =>'Item3'
                 )
            )
        );
        $postjson = json_encode($postArr);
        echo "<hr/>";
        $res = $this->connect($url,'post','json',$postjson);
        var_dump($res);
    }
    //获取用户的openid
    function  getBaseRight(){
        //获取code
        $appid = "wx2f594289390a8112";
        $redirect_uri = urlencode("http://test.lovemojito.com/wxj/www/wxtest/haoqi_xin/panduan.php");//微信服务器会将code发送到这个地址，必须在我们已经设置的域名之下，不然会报错
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('location:'.$url);//跳转的时候会返回一个code
    }
    function getUserInfo(){
//        获取网页授权的access_token
    $appid = "wx2f594289390a8112";
    $appidsecret = "22efd41cfccbfec32bb8d6d8863d2d19";
    $code = $_GET['code'];
//        var_dump($code);
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appidsecret."&code=".$code."&grant_type=authorization_code";
    $res = $this->connect($url,'get');//为了获得access_token
    $access_token = $res['access_token'];//用户的网页授权access_token
    $openid = $res['openid']; //用户的openid
    //通过access_token与openid获得用户的详细信息，地址、头像、性别等信息
    $url1 = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    $res1 = $this->connect($url1);
    $imgUrl = $res1['headimgurl'];
//        var_dump($res1);
//        echo $openid;
//    return $openid;
        $info = array(
            "openid" => $openid,//openid
            "imgurl" => $imgUrl,//头像地址
        );
        return $info;
}
   //如果不要求获得详细信息，getBaseInfo中的$url里的scope值可改为：snsapi_base，getUserOpenid里$url1之后的内容可省略。
    //jsapi_ticket票据
    function getJsApiTicket(){
        //将jsapi_ticket保存在session中
        if($_SESSION['jsapi_ticket'] && $_SESSION['jsapi_ticket_expire_time'] > time()){
            $jsapi_ticket = $_SESSION['jsapi_ticket'];
        }else{
            $access_token = $this->normal_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
            $res = $this->connect($url);
            $jsapi_ticket = $res['ticket'];
            $_SESSION['jsapi_ticket'] = $jsapi_ticket;
            $_SESSION['jsapi_ticket_expire_time'] = time() + 7200;//jsapi_ticket的有效期是2小时
        }
//        var_dump($res);
//        echo $jsapi_ticket;
        return $jsapi_ticket;
    }
    //获取16位随机码
    function getRandCode($num = 16){
        $array = array(
          'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
          'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
          '0','1','2','3','4','5','6','7','8','9'
        );
        $tmpstr = '';
        $max = count($array);
        for($i = 0;$i <= $num;$i ++){
            $key = rand(0,$max-1);//‘A’-> $array[0]
            $tmpstr .= $array[$key];
        }
        return $tmpstr;
    }
    //分享朋友圈
    function shareWX(){
        $jsapi_ticket = $this ->getJsApiTicket(); //获取jsapi_ticket
        $timestamp = time();//获取时间戳
        $noncestr = $this ->getRandCode();//获得16位随机码
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $signature = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$url;  //获取signature
        $signature = sha1($signature);
        $test = array(
            "appId"     => "wx2f594289390a8112",
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "jsapi_ticket" => $jsapi_ticket
        );
        return $test;
    }
}