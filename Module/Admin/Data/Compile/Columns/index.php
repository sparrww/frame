<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>栏目管理</title>

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
                        location.href = "<?php echo app_url('/columns/execution/re/1/message');?>" + data.message;
                    } else {
                        location.href = "<?php echo app_url('/columns/execution/re/0/message');?>" + data.message;

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
    <form method="post" action="<?php echo app_url('/columns/sort');?>" class="form">
        <div id="main_top">
            <dl id="article_ico">
                <dd class="art_ico_1"><a
                        href="<?php echo app_url('/columns/add/classid');?><?php if($_GET['classid']){?><?php if($_GET['classid']){echo $_GET['classid'];}?><?php } else { ?>0<?php }?>">添加栏目</a>
                </dd>
                <dd class="art_ico_2"><a href="javascript:void(0)" id="sort">栏目排序</a></dd>
                <?php if($_GET['classid']!=""){?>
                <dd class="art_ico_9"><a href="<?php echo app_url('/columns/index/classid/'.intval($_GET['fid']));?>">返回上级</a></dd>
                <?php }?>            </dl>
        </div>
        <div id="art_body">
            <div id="art_list">
                <table cellspacing="0">
                    <tr>
                        <th width="60">排序</th>
                        <th width="200" class="art_title_th">栏目名称</th>
                        <th width="100">类型</th>
                        <th  width="120">模块名称</th>
                        <th>模板地址</th>
                        <th>导航</th>
                        <th width="200">操作</th>
                    </tr>
                    <?php if(($array['article_list']) && is_array($array['article_list'])) { foreach($array['article_list'] as $k => $v) { ?><tr class="bg_fff">
                        <td><input type="text" name="sort[<?php if($v['id']){echo $v['id'];}?>]" value="<?php if($v['sort']){?><?php if($v['sort']){echo $v['sort'];}?><?php } else { ?>0<?php }?>"
                                   style="width:50px;text-align:center"></td>
                        <td style="text-align:left"><a
                                href="<?php echo app_url('/columns/index/classid/'.$v['id'].'/fid/'.$v['classid']);?>"><?php if($v['name']){echo $v['name'];}?></a>
                        </td>
                        <td><?php if($v['type']==1){?>模块<?php }elseif($v['type']==2) { ?>外链<?php }?></td>
                        <td><?php if($v['module']){echo $v['module'];}?></td>
                        <td><?php if($v['template']){echo $v['template'];}?></td>
                        <td><?php if($v['nav']==1){?>是<?php } else { ?>否<?php }?></td>
                        <td>
                            <a href="<?php echo app_url('/columns/edit/id/'.$v['id'].'/classid/'.$v['classid']);?>">编辑</a>
                            |
                            <a href="<?php echo app_url('/columns/delete/id/'.$v['id']);?>"
                                 onclick="javascript:return confirm('您确定要删除“<?php if($v['name']){echo $v['name'];}?>”栏目吗？')">删除</a>
                        </td>
                    </tr><?php }} ?>                </table>
            </div>
            <div id="art_sxsz"></div>
        </div>
    </form>
</div>

</body>
</html>
