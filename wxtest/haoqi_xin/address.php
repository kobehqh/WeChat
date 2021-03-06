<?php
session_start();
if(!$_SESSION['openid']){
    header("location:error.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Huggies好奇</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="css/reset.css"/>
    <script src="js/responsive.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bpopup.js"></script>
    <script src="js/address.js"></script>
    <script src="js/dxx.js"></script>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            position: relative;
        }
        .overlap{
            background: url("img/bg3.jpg") no-repeat;
            background-size: 100% 100%;
            width: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
        }
        .content{
            width: 90%;
            background: url("img/tutton.png") no-repeat;
            background-size: 100% 100%;
            margin-left: 3.5%;
            position: relative;
            padding-left: 5.5%;
            padding-right: 2%;
            color: #bf4c46;
            padding-bottom: 1rem;
        }
        .paddingDiv1{
            height: 12%
        }
        .paddingDiv2{
            width: 100%;
            height: 2rem;
            padding-top: 23%;
        }
        .theIcon{
            width: 100%;
            height: 10%;
            position: absolute;
            margin-top: -10%
        }
        .theIcon img{
            width: 80%;
            float: right;
        }
        .note1{
            text-align: right;
            padding-right: 0.5rem;
            font-size: 0.8rem;
            color: #9c6354
        }
        .please{
            text-align: center;
            color: #99685c;
            font-weight: 500;
            font-size: 1.3rem;
            margin-top: 1rem;
            letter-spacing: 0.15rem;
        }
        form{
            color: #bf4c46;
        }
        .date-select{
            /*background: white;*/
            height: 2rem;
            margin-top: 1.5rem;
        }
        .data-1{
            height: 2rem;
            line-height: 2rem;
            width: 72%;
            display: flex;
            justify-content: space-between;
        }
        .theDate{
            height: 2rem;
            float: left;
            position: relative;
            width: 33%;
        }
        .theDate select{
            width: 76%;
            padding-left: 0.5rem;
            height: 100%;
            font-size: 0.85rem;
            border-radius: 0.6rem;
            outline-style: none;
            border-style: none;
            color: #333333;
            background: white;
            float: left;
        }
        .theDate img{
            position: absolute;
            right: 27%;
            top:45%;
            width: 10%;
            pointer-events: none;
        }
        .theDate div{
            width: 24%;
            text-align: center;
            float: left;
            height: 2rem;
            line-height: 2.1rem;
        }
        .selectSpan{
            background:white;
            font-size:0.9rem;
            border-radius:0.5rem;
            position: absolute;
            height: 2rem;
            text-align: center;
            pointer-events: none;
            line-height: 2rem;
            border: 1px solid #bf4c46;
            padding-right: 10%;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #bf4c46;
            width: 78%;
        }
        .submitBtn{
            width: 10rem;
            background: url("img/button.png") no-repeat;
            background-size: 100% 100%;
            height: 2.5rem;
            margin: 2rem auto;
        }
        .role{
            text-align: right;
            position: absolute;
            bottom: 0.2rem;
            right: 0.2rem;
            font-size: 1rem;
            color: #99685c;
        }
        #element_to_pop_up,#element_to_pop_up1,#element_to_pop_up2,#element_to_pop_up3,#element_to_pop_up4,#element_to_pop_up5,#element_to_pop_up6{
            display: none;
            width: 18rem;
            background: white;
            text-align: center;
            padding:4rem 2rem;
            border: 1px solid #bf4c46;
            border-radius: 0.5rem;
            color: #bf4c46;
            font-size: 1.1rem;
            position: relative;
        }
        .name{
            margin-top: 2rem
        }
        .name div{
            width: 25%;
            float: left;
            font-size: 1rem;
            text-align: center;
            height: 2rem;
            line-height: 2rem;
            padding-right: 2rem
        }
        .name input{
            width: 50%;
            height: 2rem;
            border-style: none;
            border: 1px solid #bf4c46;
            outline-style: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }
        .sf{
            margin-top: 0.5rem;
            width: 100%;
            height: 2rem;
        }
        .sf .Procince{
            width: 25%;
            float: left;
            font-size: 1rem;
            text-align: center;
            height: 2rem;
            line-height: 2rem;
            padding-right: 2rem
        }
        .address{
            margin-top: 1.5rem
        }
        .address div{
            width: 25%;
            float: left;
            font-size: 1rem;
            text-align: center;
            height: 2rem;
            line-height: 2rem
        }
        .address input{
            width: 70%;
            height: 2rem;
            border-style: none;
            border: 1px solid #bf4c46;
            outline-style: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }
        .phone{
            margin-top: 1.5rem
        }
        .phone div{
            width: 25%;
            float: left;
            font-size: 1rem;
            text-align: center;
            height: 2rem;
            line-height: 2rem
        }
        .phone input{
            width: 40%;
            height: 2rem;
            border-style: none;
            border: 1px solid #bf4c46;
            outline-style: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }
        input{
            padding-left: 0.3rem;
        }
        #close{
            width: 1.8rem;
            height: 1.8rem;
            line-height:1.8rem;
            font-size: 1.5rem;
            position: absolute;
            right: 0.3rem;
            top: 0.3rem;
            border: 1px solid #bf4c46;
            background: url("img/close.png") no-repeat;
            background-size: 100% 100%
        }
        @media (max-height: 350px){
            .role{
                display: none;
            }
        }
        #mark{
            display: none;
        }
    </style>
</head>
<body>
<div class="overlap">
    <div class="paddingDiv1"></div>
    <div class="content">
        <div class="theIcon">
            <img src="img/icon.png">
        </div>
        <div class="paddingDiv2"></div>
        <p class="note1">*以上两款为新老包装，随机发货。</p>
        <p class="please">请认真填写以下收货信息</p>
        <div>
            <div class="name">
                <div class="ipad">姓名</div>
                <input id="name" class="ipad" name="name">
            </div>
            <form class="sf ipad" name="form1">
                <div class="Procince ipad">省份</div>
                <div class="date-select ipad">
                    <div class="data-1">
                        <div class="theDate">
                            <span id="ProvinceVal" class="selectSpan ipad">请选择</span>
                            <select id="P">
                                <option selected>请选择</option>
                            </select>
                            <div class="ipad">省</div>
                            <img src="img/iconDown.png"/>
                        </div>
                        <div class="theDate">
                            <span id="cityVal" class="selectSpan ipad">请选择</span>
                            <select id="city">
                                <option selected>请选择</option>
                            </select>
                            <div class="ipad">市</div>
                            <img src="img/iconDown.png"/>
                        </div>
                        <div class="theDate">
                            <span id="areaVal" class="selectSpan ipad">请选择</span>
                            <select id="area">
                                <option selected>请选择</option>
                            </select>
                            <div class="ipad">区</div>
                            <img src="img/iconDown.png"/>
                        </div>
                </div>
            </div>
            </form>
            <div class="address">
                <div class="ipad">收货地址</div>
                <input id="address" class="ipad" name="getaddress">
            </div>
            <div class="phone">
                <div class="ipad">手机号码</div>
                <input id="phone" class="ipad" readonly="readonly">
            </div>
            <form class="submitBtn ipad" method="post">
                <input type="button" name="mark" value="1" id="mark">
            </form>
        </div>
    </div>
    <div class="role">
        活动规则>
    </div>
    <div id="element_to_pop_up" style="display:none">
    <p>恭喜您完成填写!</p>
    <p>您的礼品将在15个工作日内</p>
    <p>尽快为您安排寄送！</p></div>
    <div id="element_to_pop_up1">不能为空</div>
    <div id="element_to_pop_up2">请输入有效手机号！</div>
    <div id="element_to_pop_up3">请填写完整信息
        <div id="close"></div></div>
    <div id="element_to_pop_up4">请输入正确格式！</div>
    <div id="element_to_pop_up5">
        <p>本次活动已结束，</p>
        <p>留意好奇微信，</p>
        <p>更多福利等你来拿哟~</p>
    </div>
    <div id="element_to_pop_up6">
        <p>哎呀！该条彩信的领取资格</p>
        <p>已被使用。留意好奇微信，</p>
        <p>更多福利等你来拿哟~</p>
    </div>
</div>
<!--获得a参数，判断显示隐藏内容-->
<script>
    var hash = window.location.href;//获取到跳转页面的参数
    var phoneHref = hash.split("phone=")[1];
    $("#phone").val(phoneHref);
</script>


<!--活动日期限定-->
<script>
    var date = new Date();//获得时间信息
    var year = date.getFullYear();//获得年
    var month = date.getMonth() + 1;//得到今月
    var day = date.getDate();//得到今日
    var phone1 = phoneHref;
    var dateFlag = true;
    if(year == 2018){
        if(month == 7 && day > 26 || month == 8 && day < 13) {
            dateFlag = true;
        }else {
            dateFlag = false;
        }
    }else {
        dateFlag = false;
    }
</script>
<!--here-->
<?php
if($_SESSION['phone'] == $_SERVER["QUERY_STRING"]){
    echo '<script language="javascript">';
    echo ' $(\'#element_to_pop_up\').bPopup({closeClass: "close",modalClose: false,zIndex: 4,opacity: 0.5});';
    echo '</script>';
}
?>
<script>
    if(!dateFlag){
            $('#element_to_pop_up5').bPopup({
                closeClass: "close",
                modalClose: false,//背景点击可关闭
                zIndex: 4,//优先显示值，越小越下面
                opacity: 0.5//透明度
            });//单击事件时触发BPOPUP
    }else {
        console.log("hello");
        // $('#element_to_pop_up5').bPopup({
        //     closeClass: "close",
        //     modalClose: false,//背景点击可关闭
        //     zIndex: 4,//优先显示值，越小越下面
        //     opacity: 0.5//透明度
        // });//单击事件时触发BPOPUP
    }
</script>

<!--姓名验证-->
<script>
    var nameFlag = true;
    $("#name").bind('blur',function(e){
        var namemsg = /^[\u4E00-\u9FA5]{2,4}$/;
        var name = document.getElementById("name").value;
        e.preventDefault();//防止默认动作被触发。
        if(name.length == 0){
            $('#element_to_pop_up1').bPopup({
                closeClass:"close",
                modalClose:true,//背景点击可关闭
                zIndex:2,//优先显示值，越小越下面
                opacity:0.5//透明度
            });//单击事件时触发BPOPUP
             return nameFlag = false;
        }else if(!namemsg.test(name)){
            $('#element_to_pop_up4').bPopup({
                closeClass:"close",
                modalClose:true,//背景点击可关闭
                zIndex:2,//优先显示值，越小越下面
                opacity:0.5//透明度
            });//单击事件时触发BPOPUP
            return nameFlag = false;
        }else {
            return nameFlag = true;
        }
    })
</script>
<!--手机号验证-->
<script>
    var phoneFlag = true;
    $("#phone").blur(function () {
        var mobile = $("#phone").val();
        var myreg = /^0?(13[0-9]|15[012356789]|17[013678]|18[0-9]|14[57])[0-9]{8}$/;//手机验证
        if(mobile.length == 0) {
            $('#element_to_pop_up1').bPopup({
                closeClass: "close",
                modalClose: true,//背景点击可关闭
                zIndex: 4,//优先显示值，越小越下面
                opacity: 0.5//透明度
            });//单击事件时触发BPOPUP
            return phoneFlag = false;
        }else if(mobile.length != 11 || !myreg.test(mobile)){
            $('#element_to_pop_up2').bPopup({
                closeClass: "close",
                modalClose: true,//背景点击可关闭
                zIndex: 4,//优先显示值，越小越下面
                opacity: 0.5//透明度
            });//单击事件时触发BPOPUP
            return phoneFlag = false;
        }else {
            return phoneFlag = true;
        }
    })//电话格式提示
</script>
<!--填写完整-->
<script>
    $(function () {// 绑定单击事件
        if(dateFlag){
            $('.submitBtn').bind('click', function (e) {
                e.preventDefault();//防止默认动作被触发。
                var mark = $("#mark").val();
                var name = $("#name").val();
                var phone = $("#phone").val();
                var getaddress = $("#address").val();
                var sf = $("#P").val() + $("#city").val() + $("#area").val();
                var flag = 0;
                for (var i = 0; i < document.form1.elements.length; i++) {//遍历form里面下一级的所有元素
                    if (document.form1.elements[i].value == "请选择") {
                        flag = 1;
                    }
                }//未填写完整地址
                if (flag || phone == "" || name == "" || getaddress == "") {//未填写一胎且未点中二胎
                    $('#element_to_pop_up3').bPopup({
                        closeClass: "close",
                        modalClose: true,//背景点击可关闭
                        zIndex: 4,//优先显示值，越小越下面
                        opacity: 0.5//透明度
                    });//单击事件时触发BPOPUP
                    console.log(name);
                }else if(!phoneFlag){
                    $('#element_to_pop_up2').bPopup({
                        closeClass: "close",
                        modalClose: true,//背景点击可关闭
                        zIndex: 4,//优先显示值，越小越下面
                        opacity: 0.5//透明度
                    });//单击事件时触发BPOPUP
                }else if(!nameFlag){
                    $('#element_to_pop_up4').bPopup({
                        closeClass: "close",
                        modalClose: true,//背景点击可关闭
                        zIndex: 4,//优先显示值，越小越下面
                        opacity: 0.5//透明度
                    });//单击事件时触发BPOPUP
                }else {
                    $.ajax({
                        url: 'phone.php',//请求的后端地址
                        type: "POST",
                        data: {
                            phone:phone,
                            mark:mark,
                            sf:sf,
                            name:name,
                            getaddress:getaddress
                        },//前端传给后端的参数
                        dataType: "json",
                        error: function(data,errorThrown){
                            console.log(data);
                            console.log(errorThrown);
                        },
                        success:function(test){
                            if(!test.used) {
                                $('#element_to_pop_up').bPopup({
                                    closeClass: "close",
                                    modalClose: false,//背景点击可关闭
                                    zIndex: 4,//优先显示值，越小越下面
                                    opacity: 0.5//透明度
                                });//单击事件时触发BPOPUP
                            }
                            // document.cookie = test.used + "," + test.phone + ',' + test.mark;
                        }
                    })
                }
            })
        }else {
            $('#element_to_pop_up5').bPopup({
                closeClass: "close",
                modalClose: false,//背景点击可关闭
                zIndex: 4,//优先显示值，越小越下面
                opacity: 0.5//透明度
            });//单击事件时触发BPOPUP
        }
    })
    $("#close").click(function () {
        $("#element_to_pop_up3").bPopup().close();
    })
</script>
<script>
    $("#P").change(function () {
        $("#ProvinceVal").text($("#P").val());
        $("#areaVal").text("请选择");
    })
    $("#city").change(function () {
        $("#cityVal").text($("#city").val());
        $("#areaVal").text("请选择");
    })
    $("#area").change(function () {
        $("#areaVal").text($("#area").val());
    })
</script>
<!--省-->
<script>
    var option1 = [];
    for(var i = 0;i<address.length;i++){
        document.createElement("option");
        option1[i] = document.createElement("option");
        option1[i].text = address[i].Provincename;
        option1[i].code = address[i].code;
        $("#P").append(option1[i]);
    }
</script>
<!--市-->
<script>
    var option2 = [];
    var obj;
    $("#P").change(function () {
        var city = document.getElementById("city");
        obj = {};
        city.options.length = 1;//初始化
        var ProvunceIndex = document.getElementById("P").options.selectedIndex - 1;
        obj = address[ProvunceIndex];
        for(var i = 0;i<obj.sub.length;i++){
            document.createElement("option");
            option2[i] = document.createElement("option");
            option2[i].text = obj.sub[i].name;
            $("#city").append(option2[i]);
        }
    })
</script>
<!--区-->
<script>
    var option3 = [];
    $("#city").change(function () {
        var area = document.getElementById("area");
        area.options.length = 1;
        var obj1 = {};
        var cityIndex = document.getElementById("city").options.selectedIndex - 1;
        obj1 = obj.sub[cityIndex];
        for(var i = 0;i<obj1.sub.length;i++){
            document.createElement("option");
            option3[i] = document.createElement("option");
            option3[i].text = obj1.sub[i].name;
            $("#area").append(option3[i]);
        }
        console.log(obj1);
    })
</script>
<!--如果宽度为ipd，某些样式发生改变-->
<script>
    if(document.body.clientWidth  > "700"){
        $(".ipad").css("height","3rem");
        $(".ipad").css("line-height","3rem");
        $(".ipad").css("font-size","1.3rem");
        $(".please").css("font-size","1.8rem")
    }
</script>
<script>
    $("body").height(window.innerHeight);
</script>
</body>
</html>
<?php
//session_destroy();
?>