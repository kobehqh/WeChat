/**
 * Created by Administrator on 2018/4/17 0017.
*/
function theTimeForm(p) {
    var d = new Date();//获得时间信息
    var next_year = d.getFullYear() + 1;//+1为明年
    var next_month = d.getMonth();//得到今月，此处意为明年今月;5.7返回4
    var next_day = d.getDate();//得到今日，此处意为明年今日
    var year = document.getElementsByClassName("year")[p];
    var month = document.getElementsByClassName("month")[p];
    var day = document.getElementsByClassName("day")[p];
    var all_day = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var m_max = next_month + 1;//设置最大月份，用于限制2019年时的月份
    var d_max = next_day;
    var s;
    data_select(2000, next_year, year);//初始化年
    data_select(1, 12, month);//初始化月
    data_select(1, 31, day);//初始化日
    var flag_date_month = 0;
    year.onchange = function () {//年与月
        var theYear = document.getElementsByClassName("year")[p].options.selectedIndex + 1999;//得到当前所选中的年份，可改进
        if(theYear == "2019"){//当选择为2019年时最大月份为明年今月
           month.options.length = 1;
           data_select(1,m_max,month);
           data_select(1,d_max,day)
        }else {
            month.options.length = 1;
            data_select(1, 12, month)
        }
    }
    month.onchange = function () {//月与日
        var m = document.getElementsByClassName("month")[p].options.selectedIndex;//selectedIndex的值从0开始，得到当前所选中的月份
        var theYear = document.getElementsByClassName("year")[p].options.selectedIndex + 1999;//得到当前所选中的年份
        if (theYear == 2019 && m == m_max) {//为2019年时
            s = d_max;
        } else {//不是2019时
            if (m == 2 && theYear % 4 == 0) {//闰年的二月(从2000年开始)
                s = 29;//29天
            } else {
                s = all_day[m - 1];
            }
        }
        day.options.length = 1;//初始化日
        data_select(1, s, day);
    }
    function data_select(i, a, dom) {//第一年/月/日 最后年/月/日  所挂的dom节点 被选择的与
        for (var j = i; j <= a; j++) {
            var option = [];
            document.createElement("option");
            var text = [];
            var t = j;
            option[j] = document.createElement("option");
            text[j] = document.createTextNode(t);
            option[j].appendChild(text[j]);
            option[j].value = j;
            dom.appendChild(option[j]);
        }
    }
}//时间表单。参数：创建时间函数选择项
function validatemobile(mobile) {
    var myreg = /^(((13[0-9]{1})| (15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    if(mobile.length == 0) {
        alert("不能为空");
        return false;
    }else if(mobile.length != 11){
        alert("请输入有效手机号！");
        return false;
    }else if(!myreg.test(mobile)){
        alert("error")
        return false;
    }
}//电话格式提示
function count_down(begin,end,dom,content,textFormerContent) {//起始时间 最终时间 所挂节点 最后显示内容
    var secondsNode = document.getElementById(dom);
    var seconds = begin;
    var timer = setInterval(function () {
        seconds--;
        secondsNode.value = textFormerContent + seconds + "秒";
        if (seconds == end-1) {
            clearInterval(timer);
            secondsNode.value = content;
        }
        return content;
    }, 1000);
}//倒计时显示
/*function myCheck() {
var flag = 0;
console.log(document.form.elements);
for(var i=0;i<document.form.elements.length;i++){//遍历form里面下一级的所有元素
    if(document.form.elements[i].value==""){
        flag=1;
    }
}
if(flag){
    alert("填写完整才能点击我哦");//弹窗
}
}
}//表单所有不能为空*/