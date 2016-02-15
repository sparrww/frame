<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="main">
	<div id="main_top">
		<b>网站信息</b>
	</div>
	<div id="art_body">
    	<table cellspacing="0" class="add_art">
        	<tr><th colspan="2"><h3>系统操作提示信息</h3></th></tr>
            <tr>
            	<td width="240"><img src="<?php echo skin('Image/duihao.png');?>" style="display:block; margin:20px auto" /></td>
            	<td style="font-size:40px; color:#131b26;"><?php if($_GET['re']=='1'){?>
					<?php echo urldecode($_GET['message']);?><?php } else { ?><?php echo urldecode($_GET['message']);?>
					<?php }?>                </td>
            </tr>
            <tr>
            	<th colspan="2">【<a href="javascript:history.go(-2)">返回列表</a>】</th>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
