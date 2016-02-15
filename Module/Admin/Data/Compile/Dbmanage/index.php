<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Pragma" CONTENT="no-cache">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Expires" CONTENT="0">
    <title>数据库管理</title>

    <!--[if IE]><script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!--><script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script><!--<![endif]-->
    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo jq('ValidForm/css.css');?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo skin('Js/tab.js');?>"></script>
    <script src="<?php echo jq('ValidForm/validform.js');?>"></script>
    <script src="<?php echo skin('Js/dbmanage.js');?>"></script>
    <script src="<?php echo skin('Js/common.js');?>"></script>
    <style>
        .botton{width:60px;height:25px;border:1px solid #ccc;margin:2px 5px}
    </style>

</head>

<body>
<div id="main">
    <form name="checkboxform" method="post" action="" class="form">
        <div id="main_top">
            <dl id="article_ico">
                <dd class="art_ico_8"><a href="<?php echo app_url();?>dbmanage/dbbackup">备份数据</a></dd>
                <dd class="art_ico_9"><a href="<?php echo app_url();?>dbmanage/dbregain">恢复数据</a></dd>
                <dd class="art_ico_6"><a href="<?php echo app_url();?>dbmanage/dbmanages">管理备份</a></dd>
            </dl>
        </div>
        <div id="art_body">
            <div id="art_list">
                <table cellspacing="0">
                    <tr>
                        <th width="30" style="cursor:pointer">选择</th>
                        <th>字段名称</th>
                        <th width="150">表注释</th>
                        <th width="100">记录数</th>
                        <th width="150">表大小</th>
                        <th width="150">操作</th>
                    </tr>
                    <?php if(($table) && is_array($table)) { foreach($table as $k => $v) { ?><tr class="bg_fff">
                    <td><input type="checkbox" id="record<?php echo intval($k+1);?>" class="record" name="dbname[]" value="<?php if($v['Name']){echo $v['Name'];}?>" checked></td>
                    <td style="text-align:left"><?php if($v['Name']){echo $v['Name'];}?></td>
                    <td><?php if($v['Comment']){echo $v['Comment'];}?></td>
                    <td><?php if($v['Rows']+1){ echo $v['Rows']+1;}?></td>
                    <td><?php echo round($v['Data_length']/1024);?></td>
                    <td>
                        <a href="<?php echo app_url();?>dbmanage/one/method/repair/dbname/<?php if($v['Name']){echo $v['Name'];}?>">修复</a> |
                        <a href="<?php echo app_url();?>dbmanage/one/method/optimize/dbname/<?php if($v['Name']){echo $v['Name'];}?>">优化</a>
                    </td>
                    </tr><?php }} ?>                </table>
            </div>
            <div id="art_sxsz">
                <div id="art_xz">
                    <input type="button" value="全选" id="art_xz_qx" onclick="checkAll()" />
                    <input type="button" value="反选" id="art_xz_fx" onclick="switchAll()" />
                    <input type="button" value="不选" id="art_xz_bx" onclick="uncheckAll()" />
                </div>
                <span><input type="button" id="repair" value="修复" class="botton"></span>
                <span><input type="button" id="optimize" value="优化" class="botton"></span>
                <span><input type="button" id="backup" value="备份" class=" botton"></span>
            </div>
        </div>
</form>
</div>
</body>
</html>