<?php
session_start();
if($_SESSION['time'] < time()){
    $_SESSION['openid'] = null;
    header("location:error.php");
}else{
    $_SESSION['time'] = time() + 120;
}
//if(!$_SESSION['openid']){//未成功获得openid
//    header("location:error.php");
//}
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
            background: url("img/bg1.jpg") no-repeat;
            background-size: 100% 100%;
            width: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
        }
        .mom{
            width: 100%;
            background: url("img/mom1.png") no-repeat;
            background-size: 100% 100%;
            height: 39%;
        }
        .note{
            width: 100%;
            padding-left: 2rem;
            color: #9c6354;
            margin-top: -0.5rem;
            font-size: 0.9rem;
        }
        .phone_check{
            width: 95%;
            margin: 0rem auto;
            background: url("img/kuang.png") no-repeat;
            background-size: 100% 100%;
            padding: 1rem 2rem 0.5rem 2rem;
            font-size: 1rem;
            color:#bf4c46;
        }
        .phone_check p{
            color: #99685c;
            font-size: 0.9rem;
            margin-top: 0.3rem;
            text-align: center;
            font-weight: 1000;
        }
        .checkBtn{
            background: url("img/checkBtn.png") no-repeat;
            background-size: 100% 100%;
            height: 2rem;
           float: right;
            width: 27%;
            margin-right: 3%;
        }
        .phone{
            float: left;
            width: 20%;
            text-align: right;
            /*height: 10%;*/
            /*line-height: 10%;*/
            height: 2rem;
            margin-right: 0.5rem;
            line-height: 2.1rem;
        }
        .phone_check input{
            width: 45%;
            /*height: 2rem;*/
            /*height: 10%;*/
            height: 2rem;
            margin-top: 0.05rem;
            border-style: none;
            border-radius: 0.5rem;
            border: 1px #bf4c46 solid;
            font-size: 0.9rem;
        }
        #submitBtn{
            width: 10rem;
            background: url("img/button.png") no-repeat;
            background-size: 100% 100%;
            height: 2.8rem;
            margin: 1.2rem auto;
        }
        .role{
            text-align: right;
            position: absolute;
            bottom: 0.2rem;
            right: 0.2rem;
            font-size: 1rem;
            color: #99685c;
        }
        .date-select{
            /*background: white;*/
            height: 2rem;
        }
        .data-1{
            height: 2rem;
            line-height: 2rem;
            width: 77%;
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
            line-height: 2rem;
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
        #element_to_pop_up,#element_to_pop_up1,#element_to_pop_up2,#element_to_pop_up3,#element_to_pop_up4,#element_to_pop_up5{
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
        .babyBirth{
            width: 20%;
            float: left;
            font-size: 1rem;
            text-align: right;
            height: 2rem;
            line-height: 2rem;
            margin-right: 0.5rem
        }
        #check{
            margin-top: 1rem
        }
        input{
            padding-left: 0.3rem;
        }
        #close,#close1,#close2{
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
    </style>
</head>
<body>
<div class="overlap">
    <div style="height:3%"></div>
    <div class="mom">
    </div>
    <div class="note">
        *以上两款为新老包装，随机发货。
    </div>
    <div class="phone_check">
        <p style="font-size: 1.2rem;" id="p1">请先完成您的手机号验证</p>
        <p id="p2">本次活动仅限收到彩信的手机号用户参与(转发无效)</p>
        <div style="margin-top: 1.2rem" id="phoneCheck">
            <div class="phone">手机号码</div>
            <input type="tel" id="phone" name="phone">
            <div class="checkBtn"></div>
        </div>
        <div>
            <div class="phone" style="padding-right: 1rem;margin-top: 1rem">验证码</div><input type="tel" id="check">
        </div>

        <div  style="margin-top: 1rem" id="theBirth">
            <div class="babyBirth">宝宝生日</div>
            <div class="date-select" id="First">
                <form class="data-1" name="form1">
                    <div class="theDate">
                        <span id="theYearSelectFirstVal" class="selectSpan">请选择</span>
                        <select class="year" id="theFirstYear">
                            <option selected>请选择</option>
                        </select>
                        <div>年</div>
                        <img src="img/iconDown.png"/>
                    </div>
                    <div class="theDate">
                        <span id="theMonthSelectFirstVal" class="selectSpan">请选择</span>
                        <select class="month" id="theFirstMonth">
                            <option selected>请选择</option>
                        </select>
                        <div>月</div>
                        <img src="img/iconDown.png"/>
                    </div>
                    <div class="theDate">
                        <span id="theDaySelectFirstVal" class="selectSpan">请选择</span>
                        <select class="day" id="theFirstDay">
                            <option selected>请选择</option>
                        </select>
                        <div>日</div>
                        <img src="img/iconDown.png"/>
                    </div>
                </form>
            </div>
        </div>
        <div id="submitBtn">
        </div>
    </div>
    <div id="element_to_pop_up">请填写完整信息！
    <div id="close"></div></div>
    <div id="element_to_pop_up1">不能为空</div>
    <div id="element_to_pop_up2">请输入有效手机号！</div>
    <div id="element_to_pop_up3">
        <p>本次活动仅限收到彩信的</p>
        <p>手机号用户参与，</p>
        <p>留意好奇微信，</p>
        <p>更多福利等你来拿哟~</p>
        <div id="close1"></div>
    </div>
    <div id="element_to_pop_up4">
        <p>哎呀！该条彩信的领取资格</p>
        <p>已被使用。留意好奇微信，</p>
       <p>更多福利等你来拿哟~</p>
        <div id="close2"></div>
    </div>
    <div id="element_to_pop_up5">
        <p>本次活动已结束，</p>
        <p>留意好奇微信，</p>
        <p>更多福利等你来拿哟~</p>
    </div>
    <p class="role">活动规则></p>
</div>
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
            $('#submitBtn').bind('click', function (e) {
                e.preventDefault();//防止默认动作被触发。
                var phone = $("#phone").val();
                var check = $("#check").val();
                var flag = 0;
                var birth = $("#theFirstYear").val() + $("#theFirstMonth").val() + $("#theFirstDay").val();
                for (var i = 0; i < document.form1.elements.length; i++) {//遍历form里面下一级的所有元素
                    if (document.form1.elements[i].value == "请选择") {
                        flag = 1;
                    }
                }//未填写一胎
                if (flag || phone == "" || check == "") {//未填写一胎且未点中二胎
                    $('#element_to_pop_up').bPopup({
                        closeClass: "close",
                        modalClose: true,//背景点击可关闭
                        zIndex: 4,//优先显示值，越小越下面
                        opacity: 0.5//透明度
                    });//单击事件时触发BPOPUP
                }else if(!phoneFlag){
                    $('#element_to_pop_up2').bPopup({
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
                            birth:birth
                        },//前端传给后端的参数
                        dataType: "json",
                        error: function(data,errorThrown){
                            console.log(data);
                            console.log(errorThrown);
                        },
                        success:function(test){
                            if(test.address == "#"){//非彩信用户
                                $('#element_to_pop_up3').bPopup({
                                    closeClass: "close",
                                    modalClose: true,//背景点击可关闭
                                    zIndex: 4,//优先显示值，越小越下面
                                    opacity: 0.5//透明度
                                });//单击事件时触发BPOPUP
                            }else {
                                if(test.used){
                                    $('#element_to_pop_up4').bPopup({//已经使用过彩信的用户，不可再领取
                                        closeClass: "close",
                                        modalClose: true,//背景点击可关闭
                                        zIndex: 4,//优先显示值，越小越下面
                                        opacity: 0.5//透明度
                                    });//单击事件时触发BPOPUP
                                }else {//未使用过彩信机会的用户
                                    location.href = test.address + test.phone;//跳转地址;
                                }
                            }
                        }
                    });
                }
            })
        }else {//活动结束
            $('#element_to_pop_up5').bPopup({
                closeClass: "close",
                modalClose: false,//背景点击可关闭
                zIndex: 4,//优先显示值，越小越下面
                opacity: 0.5//透明度
            });//单击事件时触发BPOPUP
        }
    })
    $("#close").click(function () {
        $("#element_to_pop_up").bPopup().close();
    })
    $("#close1").click(function () {
        $("#element_to_pop_up3").bPopup().close();
    })
    $("#close2").click(function () {
        $("#element_to_pop_up4").bPopup().close();
    })
</script>
<!--活动日期限定-->
<script>
    var date = new Date();//获得时间信息
    var year = date.getFullYear();//获得年
    var month = date.getMonth() + 1;//得到今月
    var day = date.getDate();//得到今日
    var dateFlag = true;
    if(year == 2018){
        if(month == 7 && day > 26 || month == 9 && day < 13) {
            dateFlag = true;
        }else {
            dateFlag = false;
        }
    }else {
        dateFlag = false;
    }
    console.log(dateFlag);
</script>
<!--select内容居中，值交换-->
<script>
    theTimeForm(0);
    $("#theFirstYear").change(function () {
        $("#theYearSelectFirstVal").text($("#theFirstYear").val());
        $("#theMonthSelectFirstVal").text("请选择");
    })
    $("#theFirstMonth").change(function () {
        $("#theMonthSelectFirstVal").text($("#theFirstMonth").val());
        $("#theDaySelectFirstVal").text("请选择");
    })
    $("#theFirstDay").change(function () {
        $("#theDaySelectFirstVal").text($("#theFirstDay").val());
    })
</script>
<script>
    if(document.body.clientWidth  > "700"){
        $(".phone_check").children("div").children().css("height","3.5rem");
        $(".phone_check").children("div").children().css("line-height","3.5rem");
        $(".phone_check").children("div").children().css("font-size","1.6rem");
        $(".theDate").css("height","3.5rem");
        $(".theDate").children("div").css("height","3.5rem");
        $(".theDate").children("div").css("line-height","3.5rem");
        $(".selectSpan").css("height","3.5rem");
        $(".selectSpan").css("font-size","1.6rem");
        $(".selectSpan").css("line-height","3.5rem");
        $("#submitBtn").css("height","4rem");
        $("#submitBtn").css("width","14rem");
        $("#p1").css("font-size","1.9rem");
        $("#p2").css("font-size","1.5rem");
    }
</script>
<script>
    $("body").height(window.innerHeight);
</script>
</body>
</html>