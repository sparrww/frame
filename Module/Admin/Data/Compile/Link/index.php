<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>友情链接管理</title>

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
                        href="<?php echo app_url('/link/add/classid');?><?php if($_GET['classid']){?><?php if($_GET['classid']){echo $_GET['classid'];}?><?php } else { ?>0<?php }?>">添加友情链接</a>
                </dd>
                <dd class="art_ico_2"><a href="javascript:void(0)" id="sort">友情链接排序</a></dd>
                <?php if($_GET['classid']!=""){?>
                <dd class="art_ico_9"><a href="<?php echo app_url('/link/index/classid/'.intval($_GET['fid']));?>">返回上级</a></dd>
                <?php }?>            </dl>
        </div>
        <div id="art_body">
            <div id="art_list">
                <table cellspacing="0">
                    <tr>
                        <th width="60">排序</th>
                        <th width="200" class="art_title_th">友情链接名称</th>
                        <th class="art_title_th">链接</th>
                        <th>传递权重</th>
                        <th width="200">操作</th>
                    </tr>
                    <?php if(($array['article_list']) && is_array($array['article_list'])) { foreach($array['article_list'] as $k => $v) { ?><tr class="bg_fff">
                        <td><input type="text" name="sort[<?php if($v['id']){echo $v['id'];}?>]" value="<?php if($v['sort']){?><?php if($v['sort']){echo $v['sort'];}?><?php } else { ?>0<?php }?>"
                                   style="width:50px;text-align:center"></td>
                        <td style="text-align:left"><a
                                href="<?php if($v['link']){echo $v['link'];}?>" target="_blank"><?php if($v['name']){echo $v['name'];}?></a>
                        </td>
                        <td style="text-align:left"><?php if($v['link']){echo $v['link'];}?></td>
                        <td><?php if($v['w_status']==1){?>是<?php } else { ?>否<?php }?></td>
                        <td>
                            <a href="<?php echo app_url('/link/edit/id/'.$v['id']);?>">编辑</a>
                            |
                            <a href="<?php echo app_url('/link/delete/id/'.$v['id']);?>"
                                 onclick="javascript:return confirm('您确定要删除“<?php if($v['name']){echo $v['name'];}?>”友情链接吗？')">删除</a>
                        </td>
                    </tr><?php }} ?>                </table>
            </div>
            <div id="art_sxsz"></div>
        </div>
    </form>
</div>

</body>
</html>
