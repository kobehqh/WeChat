
<?php
session_start();
class Wx{
    protected $appid = 'wx74a034d827725e2f';

    protected $secret = '3d1706ff66c1b7a979154a89d930e0d6';
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
    /**
     * 获取access_token方法
     */
    public function getAccessToken(){
        //定义文件名称
        $name = 'token_' . md5($this->appid . $this->secret);
        //定义存储文件路径
        $filename = __DIR__ . '/cache/' . $name . '.php';
        //判断文件是否存在,如果存在,就取出文件中的数据值,如果不存在,就向微信端请求
        if (is_file($filename) && filemtime($filename) + 7100 > time()){
            $result = include $filename;
            //定义需要返回的内容$data
            $data = $result['access_token'];
        }else{
            //        https请求方式: GET
//        https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
            //调用curl方法完成请求
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret=' . $this->secret;
            $result = $this->curl($url);
            //将返回得到的json数据转成php数组
            $result = json_decode($result,true);
            //将内容写入文件中
            file_put_contents($filename,"<?php\nreturn " . var_export($result,true) . ";\n?>");
            //定义需要返回的内容
            $data = $result['access_token'];
        }

        //将得到的access_token的值返回
        return $data;

    }

    public function getImage($mediaid,$save_dir='',$filename='')
    {
        $url = $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->getAccessToken().'&media_id='.$mediaid;
        //根据url获取远程文件
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);
        //把图片保存到指定目录下的指定文件
        file_put_contents($save_dir . $filename, $res);

        return array(
            'file_name' => $filename,
            'save_path' => $save_dir . $filename,
            'error' => 0
        );
    }
    /**
     *
     * 获取临时票据方法
     *
     * @return mixed
     */
    public function getJsapiTicket(){
        //存入文件中,定义文件的名称和路径
        $name = 'ticket_' . md5($this->appid . $this->secret);
        //定义存储文件路径
        $filename = __DIR__ . '/cache/' . $name . '.php';
        //判断是否存在临时票据的文件,如果存在,就直接取值,如果不存在,就发送请求获取并保存
        if (is_file($filename) && filemtime($filename) + 7100 > time()){
            $result = include $filename;
        }else{
            //定义请求地址
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this
                    ->getAccessToken().'&type=jsapi';
            //使用curl方法发送请求,获取临时票据
            $result = $this->curl($url);
            //转换成php数组
            $result = json_decode($result,true);
            //将获取到的值存入文件中
            file_put_contents($filename,"<?php\nreturn " . var_export($result,true) . ";\n?>");
        }
        //定义返回的数据
        $data = $result['ticket'];
        //将得到的临时票据结果返回
        return $data;
    }

    /**
     * 获取签名方法
     */
    public function sign(){
        //需要定义4个参数,分别包括随机数,临时票据,时间戳和当前url地址
        $nonceStr = $this->makeStr();
        $ticket = $this->getJsapiTicket();
        $time = time();
//        echo "<pre>";
//        print_r($_SERVER);
        //组合url
//        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        //将4个参数放入一个数组中
        $arr = array(
            'noncestr=' . $nonceStr,
            'jsapi_ticket=' . $ticket,
            'timestamp=' . $time,
            'url=' . $url
        );
        //对数组进行字段化排序
        sort($arr,SORT_STRING);
        //对数组进行组合成字符串
        $string = implode('&',$arr);
        //将字符串加密生成签名
        $sign = sha1($string);
        //由于调用签名方法的时候不只需要签名,还需要生成签名的时候的随机数,时间戳,所以我们应该返回由这些内容组成的一个数组
        $reArr = array(
            'appId' => $this->appid,
            'timestamp' => $time,
            'nonceStr' => $nonceStr,
            'signature' => $sign,
            'url' => $url,
        );
        //将数组返回
        return $reArr;
    }

    /**
     *
     * 生成随机数
     *
     * @return string
     */
    protected function makeStr(){
        //定义字符串组成的种子
        $seed = '1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0p';
        //通过循环来组成一个16位的随机字符串
        //定义一个空字符串 用来接收组合成的字符串内容
        $str = '';
        for ($i = 0;$i < 16; $i++){
            //定义一个随机数
            $num = rand(0,strlen($seed) - 1);
            //循环连接随机生成的字符串
            $str .= $seed[$num];
        }
        //将随机数返回
        return $str;
    }


    /**
     *
     * 服务器之间请求的curl方法
     *
     * @param $url 请求地址
     * @param array $field post参数
     * @return string
     */
    public function curl($url,$field = array()){
        //初始化curl
        $ch = curl_init();
        //设置请求的地址
        curl_setopt($ch,CURLOPT_URL,$url);
        //设置接收返回的数据,不直接展示在页面
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //设置禁止证书校验
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        //判断是否为post请求方式,如果传递了第二个参数,就代表是post请求,如果么有传递,第二个参数为空,就是get请求
        if (!empty($field)){
            //设置请求超时时间
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
            //设置开启post
            curl_setopt($ch,CURLOPT_POST,1);
            //传递post数据
            curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
        }
        //定义一个空字符串,用来接收请求的结果
        $data = '';
        if (curl_exec($ch)){
            $data = curl_multi_getcontent($ch);
        }
        //关闭curl
        curl_close($ch);
        //将得到的结果返回
        return $data;
    }
    //创建自定义菜单
    public function creatMenu(){
        $access_token = $this->getAccessToken();
        echo $access_token;
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $postArr = array(
            'button'=>array(            //第一个一级菜单
                array(
                    'type'=>'click',
                    'name'=>urlencode('菜单一'),
                    'key' =>'Item1'
                ),            //第二个一级菜单
                array(
                    'name' => urlencode('菜单二'),
                    'sub_button' =>array(//三个二级菜单
                        array(
                            'type'=>'view',
                            'name'=>urlencode('菜单二'), // 使用urlencode（) 避免中文转为字符而报错
                            'url' =>'http://test.lovemojito.com/hqh/fzBigWheel/guide.php'
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode('博客'),
                            'url' =>'http://111.230.69.226/hqh/blog/gbook.php'
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode('博客'),
                            'url' =>'http://111.230.69.226/hqh/blog/gbook.php'
                        ),
                    ),
                ),//第三个一级菜单
                array(
                    'type'=>'click',
                    'name'=>urlencode('菜单三'),
                    'key' =>'Item3'
                )
            )
        );
        echo "<hr/>";
        $postjson = urldecode(json_encode($postArr));
//        echo $postjson;
        echo "<hr/>";
        $this->connect($url,'post','json',$postjson);
//        $res = $this->connect($url,'post','json',$postjson);
//        var_dump($res);
    }
    //是否关注
    function attention($access_token,$openid) {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $res = $this->connect($url,'get');
        $subscribe = $res['subscribe'];//是否关注
        return $subscribe;
//        return $res;
    }
    //获取code，换取info(非静默)
    function  getBaseRight($redirect){
        //获取code
        $redirect_uri = urlencode($redirect);//微信服务器会将code发送到这个地址，必须在我们已经设置的域名之下，不然会报错
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('location:'.$url);//跳转的时候会返回一个code
    }

    //获得code,换取info(静默）
    function getBase($redirect){
        //获取code
        $redirect_uri = urlencode($redirect);//微信服务器会将code发送到这个地址，必须在我们已经设置的域名之下，不然会报错
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        header('location:'.$url);//跳转的时候会返回一个code
    }

    //获得详细信息
    function getUserInfo(){
//        获取网页授权的access_token
        $code = $_GET['code'];
//        var_dump($code);
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->secret."&code=".$code."&grant_type=authorization_code";
        $res = $this->connect($url,'get');//为了获得access_token
        $access_token = $res['access_token'];//用户的网页授权access_token
        $openid = $res['openid']; //用户的openid
        //通过access_token与openid获得用户的详细信息，地址、头像、性别等信息
        $url1 = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res1 = $this->connect($url1);
        $imgUrl = $res1['headimgurl'];
        $sex = $res1['sex'];
        $nickname = $res1['nickname'];
        $city = $res1['city'];
        $province = $res1['province'];
        $language = $res1['language'];
        $country = $res1['country'];
        $subscribe = $res1['subscribe'];
        $info = array(
            "openid" => $openid,//openid
            "imgurl" => $imgUrl,//头像地址
            "sex"    => $sex,//用户性别
            "nickname"=> $nickname, //昵称
            "city"=> $city,//城市
            "province"=> $province,
            "language"=> $language,
            "country"=> $country,
            "subscribe"=> $subscribe
        );
//        echo '<pre>';
//        print_r($info);
        return $info;
    }
    //获得openid
    function getInfo(){
//        获取网页授权的access_token
        $code = $_GET['code'];
//        var_dump($code);
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->secret."&code=".$code."&grant_type=authorization_code";
        $res = $this->connect($url,'get');//为了获得access_token
        $openid = $res['openid']; //用户的openid
        return $openid;
    }

    public function responseMsg(){
        /*
        获得请求时POST:XML字符串
        不能用$_POST获取，因为没有key
         */
        $xml_str = $GLOBALS['HTTP_RAW_POST_DATA'];
        if(empty($xml_str)){
            die('');
        }
        if(!empty($xml_str)){
            // 解析该xml字符串，利用simpleXML
            libxml_disable_entity_loader(true);
            //禁止xml实体解析，防止xml注入
            $request_xml = simplexml_load_string($xml_str, 'SimpleXMLElement', LIBXML_NOCDATA);
            //判断该消息的类型，通过元素MsgType
            switch ($request_xml->MsgType){
                case 'event':
                    //判断具体的时间类型（关注、取消、点击）
                    $event = $request_xml->Event;
                    if ($event=='subscribe') { // 关注事件
                        $this->_doSubscribe($request_xml);
                    }
                    break;
                case 'text'://文本消息
                    $this->_doText($request_xml);
                    break;
            }
        }
    }
    /**
     * 发送文本信息
     * @param  [type] $to      目标用户ID
     * @param  [type] $from    来源用户ID
     * @param  [type] $content 内容
     * @return [type]          [description]
     */
    private function _msgText($to, $from, $content) {
        $response = sprintf($this->_msg_template['text'], $to, $from, time(), $content);
        die($response);
    }
//关注后做的事件
    private function _doSubscribe($request_xml){
        //处理该关注事件，向用户发送关注信息
        $content = '你好';
        $this->_msgText($request_xml->FromUserName, $request_xml->ToUserName, $content);
    }
    private function _doText($request_xml){
        //接受文本信息
        $content = $request_xml->Content;

        if('音乐' == $content){
            $music_url='音乐网络地址链接';
            $ha_music_url='音乐网络地址链接';
            $thumb_media_id='一张图片的media_id';
            $title = '音乐名称';
            $desc = '音乐描述';
            $this->_msgMusic($request_xml->FromUserName, $request_xml->ToUserName, $music_url, $ha_music_url, $thumb_media_id, $title, $desc);
        }
    }
//发送音乐
    private function _msgMusic($to, $from, $music_url, $hq_music_url, $thumb_media_id, $title='', $desc='') {
        $response = sprintf($this->_msg_template['music'], $to, $from, time(), $title, $desc, $music_url, $hq_music_url, $thumb_media_id);
        die($response);
    }
    function isWeixinBrowser()
    {
        $isWeixinBrowser = 0;
        $useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
            $isWeixinBrowser = 0;
        } else {
            $isWeixinBrowser = 1;
        }
        return $isWeixinBrowser;
    }

}
//$obj = new Wx();
//$userInfo=$obj->responseMsg();
//测试获取access_token值的方法
//$obj = new Wx();
//$data = $obj->creatMenu();
//$data1 = $obj->responseMsg();
//echo '<pre>';
//print_r($data) ;
//print_r($data1) ;

//测试获取jsapiticket方法
//$obj = new Wx();
//$data = $obj->getJsapiTicket();
//echo $data;

//测试生成签名方法
//$obj = new Wx();
//$data = $obj->sign();
//echo '<pre>';
//print_r($data);

//$obj = new Wx();
//$data = $obj->sign();
//echo '<pre>';
//print_r($data);

?>
























