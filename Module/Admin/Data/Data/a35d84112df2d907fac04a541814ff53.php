<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台登录</title>
    <link href="/Public/Common/Jquery/ValidForm/css.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Css/login.css" rel="stylesheet" type="text/css" />


    <!--[if IE]><script src="/Public/Common/Jquery/jquery-1.11.1.min.js"></script><![endif]-->
    <!--[if !IE]><!--><script src="/Public/Common/Jquery/jquery-2.1.1.min.js"></script><!--<![endif]-->
    <script src="/Public/Common/Jquery/ValidForm/validform.js"></script>
    <script src="/Public/Admin/Js/IE6-PNg-min.js'}"></script>
    <script language="javascript">
        DD_belatedPNG.fix('div,ul,img,li,input,dl,dt,dd,a,header,footer,section,details,aside,menu,nav,article,hgroup,figure,figcaption,span');
    </script>
    <script type="text/javascript">
        $(function(){
            data=$(".form").Validform({
                tiptype:1,
                callback:function(data){
                    if(data.status=="y"){
                        top.location.href ="/Admin/home/index";
                    }else if(data.status=="c"){
                        alert('认证码不正确！');
                    }else if(data.status=="n"){
                        alert('用户名或密码不正确！');
                    }
                }
            });
            $("body").keydown(function() {
                if (event.keyCode == "13") {//keyCode=13是回车键
                    $("#login").trigger("click");
                }
            });
            $("#login").click(function(){
                data.ajaxPost();
                $.Hidemsg();
            });
            $(".landing input").focus(function(){

                this.style.color="#000";

            })
            $(".landing input").blur(function(){

                this.style.color="#d9d9d9";
            })
        })
    </script>
</head>


<body>
<div class="landing">
    <div class="logo"><img src="/Public/Admin/Image/logo.jpg" /></div>
    <form method="post" action="" class="form">
        <div class="user">
            <h2>用户登录<span>User Login</span></h2>
            <input type="text" value="用户名" datatype='*' nullmsg='请输入用户名'  name="user"  onfocus="if(this.value=='用户名'){this.value=''}" onblur="if(this.value==''){this.value='用户名'}" class="uhm" />
            <input value="密码" name="password"  datatype="*3-255" onfocus="if(this.value=='密码'){this.value=''; type='password'}" onblur="if(this.value==''){this.value='密码'; type='text'}" class="pass" />
            <input type="text" value="认证码" name="admincode" id="admincode" maxlength="4" datatype="*4-4" onfocus="if(this.value=='认证码'){this.value=''}" onblur="if(this.value==''){this.value='认证码'}" class="rzm" />
            <input type="button" id="login" value="登 录" class="dl" />
        </div>
    </form>
</div>
</body>
</html>