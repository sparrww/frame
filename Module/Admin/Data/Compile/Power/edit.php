<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Expires" CONTENT="0">

    <title>网站设置</title>

    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo jq('ValidForm/css.css');?>" rel="stylesheet" type="text/css"/>

    <!--[if IE]>
    <script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!-->
    <script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script>
    <!--<![endif]-->
    <script src="<?php echo jq('ValidForm/validform.js');?>"></script>
    <script src="<?php echo skin('js/common.js');?>"></script>

    <script type="text/javascript">

        window.onload = function () {
            data = $(".form").Validform({
                tiptype: 2,
                callback: function (data) {
                    if(data.status=="y"){
                        location.href =	"<?php echo app_url('/power/execution/re/1/message');?>"+data.message;
                    }else{
                        location.href =	"<?php echo app_url('/power/execution/re/0/message');?>"+data.message;
                    }
                }
            });


            $("#save").click(function () {
                data.ajaxPost();
                $.Hidemsg();
            });
        };
    </script>

</head>
<body>
<div id="main">
    <form method="post" action="<?php echo app_url();?>/power/save/id/<?php if($array['article']['id']){echo $array['article']['id'];}?>" class="form">
        <div id="main_top">
            <dl id="article_ico">
                <dd class="art_ico_8"><a href="javascript:void(0)" id="save">保存权限组</a></dd>
                <dd class="art_ico_9"><a href="javascript:history.go(-1)">取消返回</a></dd>
            </dl>
        </div>
        <div id="art_body">
            <table cellspacing="0" class="add_art">
                <tr>
                    <th>权限组名称：</th>
                    <td width="320"><input name="name" type="text" id="name" class="inputxt" style="width:300px"
                                           datatype="*1-8" nullmsg="栏目名称为能为空！" errormsg="栏目名称为1-8个字符！"
                                           value="<?php if($array['article']['name']){echo $array['article']['name'];}?>"/></td>
                </tr>
                <tr>
                    <th>权限：</th>
                    <td width="1320">
                        <?php if(($array['list']) && is_array($array['list'])) { foreach($array['list'] as $k => $v) { ?><?php if($v['operate']=='construct'){?><br><?php }?>                        <span <?php if($v['operate']=='construct'){?>style="color: #0000ff"<?php }?>><input name="class_id[]"
                                                                                                type="checkbox"
                                                                                                id="record<?php if($v['id']){echo $v['id'];}?>"
                                                                                                value="<?php if($v['id']){echo $v['id'];}?>"
                                                                                                <?php if(in_array($v['id'],$array['article']['class_id'])){?>
                                                                                                checked <?php }?>/><?php if($v['name']){echo $v['name'];}?></span><?php }} ?>                    </td>
                    <td><span class="article_notes colorf60">※：请选择。</span></td>
                </tr>
            </table>
        </div>
    </form>
</div>
</body>
</html>
