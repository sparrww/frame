<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Expires" CONTENT="0">

    <title>后台管理</title>

    <!--[if IE]>
    <script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!-->
    <script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script>
    <!--<![endif]-->
    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo skin('Js/home.js');?>"></script>
    <script src="<?php echo skin('Js/tab.js');?>"></script>

</head>

<body id="bodyie6">

<?php include Lib\Template::Tpl("top.html"); ?>
<div class="h-partent">
    <?php include Lib\Template::Tpl("menu.html"); ?>
    <div class="h-iframe">
        <iframe name="main" id="ifmain" width="100%" style="height:100%;overflow-y:auto;" align="middle" marginwidth="0"
                marginheight="0" frameborder="0" allowtransparency="true" application="true" scrolling="yes"
                src="/Admin/home/main"></iframe>
    </div>
</div>
<?php include Lib\Template::Tpl("foot.html"); ?>

</body>
</html>
