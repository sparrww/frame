<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理</title>

<link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />
<!--[if IE]><script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
<!--[if !IE]><!--><script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script><!--<![endif]-->
<script src="<?php echo jq('ValidForm/validform.js');?>"></script>

</head>

<body>

<div id="main">
	<form method="post" action="<?php echo app_url('/columns/sort');?>" class="form">
		<div id="main_top">
			<dl id="article_ico">
				<dd class="art_ico_1"><a href="<?php echo app_url('/power/add');?>">添加权限组</a></dd>
			</dl>
		</div>
		<div id="art_body">
			<div id="art_list">
				<table cellspacing="0">
					<tr>
						<th width="200" class="art_title_th">权限组名称</th>
						<th width="200">操作</th>
					</tr><?php if(($array) && is_array($array)) { foreach($array as $k => $v) { ?><tr class="bg_fff">
                        <td style="text-align:left;padding-left: 50px;"><?php if($v['name']){echo $v['name'];}?></td>
						<td><a href="<?php echo app_url('/power/edit/id/'.$v['id']);?>">编辑</a> | <a href="<?php echo app_url('/power/delete/id/'.$v['id']);?>" onclick="javascript:return confirm('您确定要删除“<?php if($v['name']){echo $v['name'];}?>”权限组吗？')">删除</a></td>
					</tr><?php }} ?></table>
			</div>
			<div id="art_sxsz"></div>
		</div>
	</form>
</div>

</body>
</html>
