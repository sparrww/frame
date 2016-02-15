<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<div id="top">
	<div id="logo"><a href="index.php"><img src="/Public/Admin/Image/logo.png" /></a></div>
    <div class="f-l">
    	快速通道：<a href="index.php">后台管理首页</a>
        <a href="<?php echo app_url();?>base/index" target="main">基本信息设置</a>
        <a href="<?php echo app_url();?>control/rdHtml" onclick='return confirm("你确定要删除所有缓存文件吗？");'>清除所有缓存文件</a>
    </div>
	<div id="top_link">
    	[<a href="/" target="_blank" title="点击打开网站前台首页">网站首页</a>]
    	[<a href="<?php echo app_url();?>home/quit" title="点击退出网站后台">退出后台</a>]
    </div>
</div>
