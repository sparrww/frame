<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>后台首页</title>
    <!--[if IE]>
    <script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!-->
    <script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script>
    <!--<![endif]-->
    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css"/>
</head>

<body style="background:#f7f7f7 url(/Public/Admin/Image/main.jpg) no-repeat 0 20px">

<div id="main">
    <div id="main_top"><span class="colorf60"><?php if($_SESSION['manage']){echo $_SESSION['manage'];}?></span>，你好，你已经进入到《<span class="colorf60"><?php if($_SESSION['base_name']){echo $_SESSION['base_name'];}?></span>》管理后台。
        你的身份：<span class="colorf60"><?php if($_SESSION['power_name']?$_SESSION['power_name']:'超级管理员'){ echo $_SESSION['power_name']?$_SESSION['power_name']:'超级管理员';}?></span>。
    </div>
    <div id="main_body" style="">

    </div>
</div>
</body>
</html>