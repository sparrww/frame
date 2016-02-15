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
    <script src="<?php echo skin('Js/checkAll.js');?>"></script>

</head>

<body>
<div id="main" style="margin-top:-10px; overflow:hidden;">
    <form name="checkboxform" method="post" action="" class="form">
        <div id="art_body" style="padding-top:0;">
            <div id="art_class">
                <ul>
                    <li class="art_ico_lm"><strong><a href="javascript:void(0)">日志列表</a></strong></li>
                </ul>
            </div>
            <div id="art_list">
                <table cellspacing="0">
                    <tr>
                        <th width="40">选择</th>
                        <th>id</th>
                        <th>控制器</th>
                        <th>方法</th>
                        <th>信息</th>
                        <th>时间</th>
                        <th>操作人</th>
                    </tr>
                    <?php if(($array['log_list']) && is_array($array['log_list'])) { foreach($array['log_list'] as $k => $v) { ?><tr>
                        <td width="40"><input type="checkbox" class="record" id="record<?php echo intval($k+1);?>" name="record[]" value="<?php if($v['id']){echo $v['id'];}?>" /></td>
                        <td><span><?php if($v['id']){echo $v['id'];}?></a></span>
                        </td>
                        <td><?php if($v['controller']){echo $v['controller'];}?></td>
                        <td><?php if($v['operate']){echo $v['operate'];}?></td>
                        <td>
                            <?php if($v['message']){echo $v['message'];}?>
                        </td>
                        <td><?php echo date('Y-m-d H:i:s',$v['datetime']);?></td>
                        <td><?php if($v['user']){echo $v['user'];}?></td>
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
