<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Pragma" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Expires" CONTENT="0">
    <title>用户管理</title>

    <!--[if IE]><script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!--><script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script><!--<![endif]-->
    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo skin('Js/tab.js');?>"></script>

</head>

<body>
<div id="main" style="overflow:hidden;">
    <form name="checkboxform" method="post" action="" class="form">
        <div id="main_top">
            <dl id="article_ico">
                <dd class="art_ico_1"><a href="<?php echo app_url('/user/add');?>">添加用户</a></dd>
                <dt class="art_ico_7"><span>快速导航</span>
                </dt>
            </dl>
        </div>
        <div id="art_body" style="padding-top:33px;">
            <div id="art_class">
                <ul>
                    <li class="art_ico_lm"><strong><a href="javascript:void(0)">管理员列表</a></strong></li>
                </ul>
            </div>
            <div id="art_list">
                <table cellspacing="0">
                    <tr>
                        <th width="40">选择</th>
                        <th style="width:205px">登录名</th>
                        <th style="width:331px" align="center">上次登录</th>
                        <th style="width:191px" align="center">权限组</th>
                        <th width="111">操作</th>
                    </tr>
                    <?php if(($array['user_list']) && is_array($array['user_list'])) { foreach($array['user_list'] as $k => $v) { ?><tr>
                        <td width="40"><input type="checkbox" class="record" id="record<?php echo intval($k+1);?>" name="record[]" value="<?php if($v['id']){echo $v['id'];}?>" /></td>
                        <td><span <?php if($v['status']==0){?>style="color: red"<?php }?>><?php if($v['admin']){echo $v['admin'];}?></a></span>
                        </td>
                        <td><?php if($v['datetime']){echo $v['datetime'];}?></td>
                        <td><?php if($v['power_id']==0){?>
                            超级管理员
                            <?php } else { ?>                            <?php if($v['name']){echo $v['name'];}?>
                            <?php }?></td>
                        <td width="100">
                            <?php if($v['power_id']==0){?>
                            超级管理员不可编辑
                            <?php } else { ?>                        <a href="<?php echo app_url('/user/edit/id/'.$v['id']);?>">编辑</a> | <a href="<?php echo app_url('/user/delete/id/'.$v['id']);?>" onclick="javascript:return confirm('您确定要删除“<?php if($v['admin']){echo $v['admin'];}?>”用户吗？')">删除</a>
                            <?php }?>                        </td>
                    </tr><?php }} ?>                </table>
                <div id="art_sxsz">
                    <div id="art_xz"><input type="button" value="全选" id="art_xz_qx" onclick="checkAll()" /><input type="button" value="反选" id="art_xz_fx" onclick="switchAll()" /><input type="button" value="不选" id="art_xz_bx" onclick="uncheckAll()" /></div>
                </div>
                <div id="art_fenye">
                    <dl><?php if($array['fy']){echo $array['fy'];}?></dl>
                </div>
            </div>
        </div>
        <input type="hidden" name="method" id="method"><input type="hidden" name="parameter" id="parameter">
    </form>
</div>
<div class="theme-popover-mask"></div>
</body>
</html>
