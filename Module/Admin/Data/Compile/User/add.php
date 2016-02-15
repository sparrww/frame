<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" CONTENT="no-cache">     
<meta http-equiv="Cache-Control" CONTENT="no-cache">     
<meta http-equiv="Expires" CONTENT="0">

<title>修改密码</title>

<link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo jq('ValidForm/css.css');?>" rel="stylesheet" type="text/css" />

<!--[if IE]><script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
<!--[if !IE]><!--><script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script><!--<![endif]-->
<script src="<?php echo jq('ValidForm/validform.js');?>"></script>

<script type="text/javascript">
$(function(){
	data=$(".form").Validform({
		tiptype:2,
		callback:function(data){
			if(data){
				location.href =	"<?php echo app_url('/user/execution');?>message/" + data.message;
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
<div id="main">
<form method="post" action="<?php echo app_url('/user/save');?>" class="form">
	<div id="main_top">
		<dl id="article_ico">
			<dd class="art_ico_8"><a href="javascript:void(0)" id="save">保存信息</a></dd>
            <dd class="art_ico_9"><a href="javascript:history.go(-1)">取消返回</a></dd>
		</dl>
	</div>
	<div id="art_body">
		<table cellspacing="0" class="add_art">
			<tr>
				<th>管理员：</th>
				<td width="500"><input type="text" name="admin" class="inputxt"  datatype="*1-8" nullmsg="名称为能为空！" errormsg="名称为1-8个字符！"></td>
                <td><span class="article_notes colorf60">※：请输入名称</span></td>
			</tr>
            <tr>
                <th>权限组：</th>
                <td >
                    <?php if(($array['list']) && is_array($array['list'])) { foreach($array['list'] as $v) { ?><input type="radio" name="power_id" value="<?php if($v['id']){echo $v['id'];}?>" checked><?php if($v['name']){echo $v['name'];}?><?php }} ?>                </td>
                <td><span class="article_notes colorf60">※：请选择权限组</span></td>
            </tr>
			<tr>
				<th>输入密码：</th>
				<td width="320"><input name="password" type="password" id="password" class="inputxt" style="width:300px" datatype="*6-15" errormsg="密码范围在6~15位之间！" /></td>
				<td><span class="article_notes colorf60">※：请输入密码</span></td>
			</tr>
            <tr>
                <th>确认密码：</th>
                <td width="320"><input name="repassword" type="password" id="repassword" class="inputxt" style="width:300px" datatype="*" recheck="password" errormsg="您两次输入的账号密码不一致！" /></td>
                <td><span class="article_notes colorf60">※：请确认密码</span></td>
            </tr>
            <tr>
                <th>状态：</th>
                <td>
                    <input type="radio" name="status" value="1" checked/>使用中
                    <input type="radio" name="status" value="0"/>离职
                </td>
                <td><span class="article_notes colorf60">※：请选择权限组</span></td>
            </tr>
		</table>
	</div>
</div>
</form>
 </body>
</html>