<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>关键词链接管理</title>

    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css"/>
    <!--[if IE]>
    <script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!-->
    <script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script>
    <!--<![endif]-->
    <script src="<?php echo jq('ValidForm/validform.js');?>"></script>
    <script type="text/javascript">
        $(function () {
            data = $(".form").Validform({
                tiptype: 2,
                callback: function (data) {
                    if (data.status == "y") {
                        location.href = "<?php echo app_url('/link/execution/re/1/message');?>" + data.message;
                    } else {
                        location.href = "<?php echo app_url('/link/execution/re/0/message');?>" + data.message;
                    }
                }
            });

            $("#sort").click(function () {
                data.ajaxPost();
                $.Hidemsg();
            });

        });
    </script>


</head>

<body>
<div id="main" style="overflow:hidden;">
    <form method="post" action="<?php echo app_url('/link/sort');?>" class="form">
        <div id="main_top">
            <dl id="article_ico">
                <dd class="art_ico_1"><a
                        href="<?php echo app_url('/tagLink/add/classid');?><?php if($_GET['classid']){?><?php if($_GET['classid']){echo $_GET['classid'];}?><?php } else { ?>0<?php }?>">添加关键词链接</a>
                </dd>
                <?php if($_GET['classid']!=""){?>
                <dd class="art_ico_9"><a href="<?php echo app_url('/tagLink/index/classid/'.intval($_GET['fid']));?>">返回上级</a></dd>
                <?php }?>            </dl>
        </div>
        <div id="art_body">
            <div id="art_list">
                <table cellspacing="0">
                    <tr>
                        <th width="300">关键词链接名称</th>
                        <th>链接</th>
                        <th width="200">操作</th>
                    </tr>
                    <?php if(($array['article_list']) && is_array($array['article_list'])) { foreach($array['article_list'] as $k => $v) { ?><tr class="bg_fff">
                        <td><a
                                href="<?php if($v['link']){echo $v['link'];}?>" target="_blank"><?php if($v['name']){echo $v['name'];}?></a>
                        </td>
                        <td><?php if($v['link']){echo $v['link'];}?></td>
                        <td>
                            <a href="<?php echo app_url('/tagLink/edit/id/'.$v['id']);?>">编辑</a>
                            |
                            <a href="<?php echo app_url('/tagLink/delete/id/'.$v['id']);?>"
                                 onclick="javascript:return confirm('您确定要删除“<?php if($v['name']){echo $v['name'];}?>”关键词链接吗？')">删除</a>
                        </td>
                    </tr><?php }} ?>                </table>
            </div>
            <div id="art_sxsz"></div>
        </div>
    </form>
</div>

</body>
</html>
