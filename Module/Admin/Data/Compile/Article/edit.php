<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" CONTENT="no-cache">
<meta http-equiv="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Expires" CONTENT="0">
<title>文章管理 - 文章修改</title>


<link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo jq('ValidForm/css.css');?>" rel="stylesheet" type="text/css" />

<!--[if IE]><script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
<!--[if !IE]><!--><script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script><!--<![endif]-->
<script src="<?php echo jq('ValidForm/validform.js');?>"></script>
<script src="<?php echo editer('kindeditor.js');?>"></script>
<script src="<?php echo editer('lang/zh_CN.js');?>"></script>
<script src="<?php echo skin('Js/common.js');?>"></script>

<script type="text/javascript">
$(function(){
	data=$(".form").Validform({
		tiptype:2,
		callback:function(data){
			if(data.status=="y"){
				location.href =	"<?php echo app_url('/article/execution/re/1/message');?>"+data.message;
			}else{
				location.href =	"<?php echo app_url('/article/execution/re/0/message');?>"+data.message;
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
	<form method="post" action="<?php echo app_url('/article/save/id/'.$article['id']);?>" class="form">
		<div id="main_top">
			<dl id="article_ico">
				<dd class="art_ico_8"><a href="javascript:void(0)" id="save">保存文章</a></dd>
				<dd class="art_ico_9"><a href="<?php echo app_url('/article/index');?>">取消返回</a></dd></dl>
		</div>
		<div id="art_body">
	<table cellspacing="0" class="add_art">
		<tr>
		<th>标题:</th>
			<td width="650"><input id="title" name="title" type="text" class="inputxt" style="width:300px"  datatype="*1-255" nullmsg="请填写信息！" errormsg="姓名要1-255个字符！" value="<?php if($article['title']){echo $article['title'];}?>"/></td>
			<td><span class="article_notes colorf60">※：录入文章标题，不要太长，不利于SEO。</span></td>
		</tr>
		<tr>
			<th>所属分类:</th>
			<td width="320">
			<select name="columnsid" id="columnsid">
				<?php if($classSelect){echo $classSelect;}?>
			</select>
			</td>
			<td><span class="article_notes colorf60">※：请输入栏目名称。</span></td>
		</tr>
		<tr>
			<th>文章属性:</th>
			<td>
				<label for="attrib_j" style="margin:0 auto;padding:0 5px"><input id="attrib_j" name="attrib_j" type="checkbox" value="1" <?php if($article['attrib_j']==1){?>checked<?php }?> /> 推荐</label>
				<label for="attrib_g" style="margin:0 auto;padding:0 5px"><input id="attrib_g" name="attrib_g" type="checkbox" value="1" <?php if($article['attrib_g']==1){?>checked<?php }?>/> 滚动</label>
				<label for="attrib_t" style="margin:0 auto;padding:0 5px"><input id="attrib_t" name="attrib_t" type="checkbox" value="1" <?php if($article['attrib_t']==1){?>checked<?php }?> /> 头条</label>
				<label for="attrib_r" style="margin:0 auto;padding:0 5px"><input id="attrib_r" name="attrib_r" type="checkbox" value="1" <?php if($article['attrib_r']==1){?>checked<?php }?> /> 热门</label>
				<label for="attrib_d" style="margin:0 auto;padding:0 5px"><input id="attrib_d" name="attrib_d" type="checkbox" value="1" <?php if($article['attrib_d']==1){?>checked<?php }?> /> 固顶</label>
				<label for="attrib_h" style="margin:0 auto;padding:0 5px"><input id="attrib_h" name="attrib_h" type="checkbox" value="1" <?php if($article['attrib_h']==1){?>checked<?php }?> /> 幻灯</label>
			</td>
			<td><span class="article_notes colorf60">※：勾选文章要赋予的特殊属性，便于前台调用。</span></td>
		</tr>
        <tr><th>来源:</th>
            <td width="650"><input id="origin" name="origin" type="text" class="inputxt" style="width:300px" value="<?php if($article['origin']){echo $article['origin'];}?>"/></td>
            <td><span class="article_notes colorf60">※：录入文章来源。</span></td>
        </tr>
        <th>关键词:</th>
        <td width="650"><input id="tags" name="tags" type="text" class="inputxt" style="width:300px"  value="<?php if($article['tags']){echo $article['tags'];}?>"/></td>
        <td><span class="article_notes colorf60">※：录入文章关键词。</span></td>
        </tr>
		<script type="text/javascript">
			//设置编辑器
		KindEditor.ready(function(K) {
			var editor = K.editor({
							allowFileManager : true
						});
				//加载上传图片
				K('#image').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							imageUrl : K('#img').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#img').val(url);
								editor.hideDialog();
							}
						});
					});
				});

                K('#image2').click(function() {
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            showRemote : false,
                            imageUrl : K('#img2').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                K('#img2').val(url);
                                editor.hideDialog();
                            }
                        });
                    });
                });
		});
		</script>
		<tr>
			<th>文章图片1:</th>
			<td>
			<input type="text" name="img" id="img" value="<?php if($article['img']){echo $article['img'];}?>" class="inputxt" style="width:300px"/> <input type="button" id="image" value="选择图片" class="admin_button inputxt" style="width:100px;height:30px;" />
			</td>
			<td><span class="article_notes colorf60">※：上传文章的封面图片。</span></td>
		</tr>
        <tr>
            <th>文章图片2:</th>
            <td>
                <input type="text" name="img2" id="img2" value="<?php if($article['img2']){echo $article['img2'];}?>" class="inputxt" style="width:300px"/> <input type="button" id="image2" value="选择图片" class="admin_button inputxt" style="width:100px;height:30px;" />
            </td>
            <td><span class="article_notes colorf60">可选：上传文章内容部分调用图片。</span></td>
        </tr>
		<tr>
			<th>文章导读:</th>
			<td colspan="2"><textarea name="info" id="info" class="inputxt" ignore="ignore" altercss="gray" class="gray" style="width:500px;height:120px"><?php if($article['info']){echo $article['info'];}?></textarea><span class="notes colorf60"><br />※：如果不填写文章导读，将自动截取文章详细内容的前200个字为导读。</span></td>
			</tr><tr>
			<th>文章内容:</th>
			<td colspan="2"><textarea class="content" id="content" name="content" style="width:98%;height:500px;"><?php if($article['content']){echo $article['content'];}?></textarea></td>
		</tr>
        <tr><th>文章地址:</th>
            <td width="650"><input id="html" name="html" type="text" class="inputxt" style="width:300px" value="<?php if($article['html']){echo $article['html'];}?>"/></td>
            <td><span class="article_notes colorf60">※：录入文章地址。</span></td>
        </tr>
        <tr><th>职称:</th>
            <td width="650"><input id="academic_title" name="academic_title" type="text" class="inputxt" style="width:300px" value="<?php if($article['academic_title']){echo $article['academic_title'];}?>"/></td>
            <td><span class="article_notes colorf60">※：录入人员内职称。</span></td>
        </tr>
        <tr>
            <th>荣誉:</th>
            <td colspan="2"><textarea name="honours" id="honours" style="width:500px;height:120px"><?php if($article['honours']){echo $article['honours'];}?></textarea><span class="notes colorf60"><br />※：录入人员荣誉。</span></td>
        </tr>
        <tr>
            <th>擅长领域:</th>
            <td colspan="2"><textarea name="adept" id="adept" style="width:500px;height:120px"><?php if($article['adept']){echo $article['adept'];}?></textarea><span class="notes colorf60"><br />※：录入人员擅长领域。</span></td>
        </tr>
        <tr>
            <th>文章状态:</th>
            <td>
                <input name="status" type="radio" value="2" <?php if($article['status']==2){?>checked="checked"<?php }?>/>审核
                <input name="status" type="radio" value="1" <?php if($article['status']==1){?>checked="checked"<?php }?>/>通过

            </td>
            <td><span class="article_notes colorf60">※：文章状态。</span></td>
        </tr>
		<tr>
		<input type="hidden" name="time" id="time" value="<?php echo time('');?>">
	</table>
		</div>
	</form>
</div>

</body>
</html>
