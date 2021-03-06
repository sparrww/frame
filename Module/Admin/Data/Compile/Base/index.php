<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" CONTENT="no-cache">     
<meta http-equiv="Cache-Control" CONTENT="no-cache">     
<meta http-equiv="Expires" CONTENT="0">

<title>网站设置</title>

<link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo jq('ValidForm/css.css');?>" rel="stylesheet" type="text/css" />

<!--[if IE]><script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
<!--[if !IE]><!--><script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script><!--<![endif]-->
<script src="<?php echo jq('ValidForm/validform.js');?>"></script>
<!-- <script src="<?php echo skin('js/common.js');?>"></script> -->

<script type="text/javascript">
$(function(){
	data=$(".form").Validform({
		tiptype:2,
		callback:function(data){
			if(data.status=="y"){
				location.href =	"<?php echo app_url('/base/execution/re/1');?>";
			}else{
				alert(data.message);
				location.href =	"<?php echo app_url('/base/execution/re/0');?>";

			}
		}
	});

	$("#save").click(function(){
		data.ajaxPost();
		$.Hidemsg();
	});
});
</script>

</head>
<body>
<div id="main" style="overflow:hidden;">
<form method="post" action="<?php echo app_url('/base/save');?>" class="form">
	<div id="main_top">
		<dl id="article_ico">
			<dd class="art_ico_8"><a href="javascript:void(0)" id="save">保存配置</a></dd>
		</dl>
	</div>
	<div id="art_body">
		<table cellspacing="0" class="add_art">
			<tr>
				<th>网站名称：</th>
				<td width="320"><input name="name" type="text" id="name" class="inputxt" style="width:300px" datatype="*1-255" errormsg="网站名称至少6个字符！" value="<?php if($array['article']['name']){echo $array['article']['name'];}?>" /></td>
				<td><span class="article_notes colorf60">※：网站的简短名称</span></td>
			</tr>
			<tr>
				<th>网站标题：</th>
				<td><input name="title" type="text" id="title" class="inputxt" style="width:300px" datatype="*1-255" errormsg="网站标题至少6个字符！" value="<?php if($array['article']['title']){echo $array['article']['title'];}?>" /></td>
				<td><span class="article_notes colorf60">※：网站标题</span></td>
			</tr>
			<tr>
				<th>网站域名：</th>
				<td><input name="domran" type="text" id="domran" class="inputxt" style="width:300px" datatype="*5-255" errormsg="网站标题至少5个字符！" value="<?php if($_SERVER['SERVER_NAME']){echo $_SERVER['SERVER_NAME'];}?>" /></td>
				<td><span class="article_notes colorf60">※：自动获取，请勿修改</span></td>
			</tr>
			<tr>
				<th>关键词：</th>
				<td><input name="keys" type="text" id="keys" class="inputxt" style="width:300px" datatype="*" errormsg="网站关键词不能为空！"  value="<?php if($array['article']['keys']){echo $array['article']['keys'];}?>" /></td>
				<td><span class="article_notes colorf60">※：KeyWords，针对搜索引擎</span></td>
			</tr>
			<tr>
				<th>站点描述：</th>
				<td><textarea name="description" id="description" altercss="gray" class="gray" style="width:500px; margin-left:5px;" datatype="*" errormsg="站点描述不能为空！"><?php if($array['article']['description']){echo $array['article']['description'];}?></textarea></td>
				<td><span class="article_notes colorf60">※：description，针对搜索引擎</span></td>
			</tr>
            <tr>
                <th>商务通链接：</th>
                <td><input name="sw_link" type="text" id="sw_link" class="inputxt" style="width:300px"  value="<?php if($array['article']['sw_link']){echo $array['article']['sw_link'];}?>" /></td>
                <td><span class="article_notes colorf60">※：商务通链接</span></td>
            </tr>
			<tr>
				<th>版权信息：</th>
				<td><textarea name="copyright" id="copyright" altercss="gray" class="gray" style="width:500px;margin-left:5px;" datatype="*" errormsg="版权信息不能为空！" ><?php if($array['article']['copyright']){echo $array['article']['copyright'];}?></textarea></td>
				<td><span class="article_notes colorf60">※：版权信息，支持Html代码</span></td>
			</tr>
			<tr>
				<th>首页模板：</th>
				<td><input type="text" name="template" id="template_url" value="<?php if($array['article']['template']){echo $array['article']['template'];}?>" class="inputxt" style="width:300px" datatype="*6-255" errormsg="网站名称至少6个字符！"/><!--  <input type="button" id="filemanage" value="浏览模板" class="inputxt" style="width:100px;height:30px;" /> --></td>
				<td><span class="article_notes colorf60">※：一般无需修改</span></td>
			</tr>
		</table>
	</div>
</div>
</form>
 </body>
</html>
