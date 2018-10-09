<?php
    $image="http://test.lovemojito.com/wxj/www/wxtest/haoqi_xin/img/mom1.png";                //图片地址
    $fp = fopen($image, 'rb');
    $content = fread($fp, filesize($image)); //二进制数据
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api-cn.faceplusplus.com/facepp/v3/detect",     //输入URL
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array('image_file";filename="image'=>"$content", 'api_key'=>"Vu5mA2oQorPy3R58pUUr0eGFUUiy2qZO",'api_secret'=>"dNWz2_K3o2Pqn36yhNOvtBuzyBLcyjeo",'return_landmark'=>"0",'return_attributes'=>"gender,age,smiling,headpose,facequality,blur,eyestatus,emotion,ethnicity,beauty,mouthstatus,eyegaze,skinstatus"),   //输入api_key和api_secret
        CURLOPT_HTTPHEADER => array("cache-control: no-cache",),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
?>
