<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>内容管理</title>

    <link href="<?php echo skin('Css/css.css');?>" rel="stylesheet" type="text/css"/>

    <!--[if IE]>
    <script src="<?php echo jq('jquery-1.11.1.min.js');?>"></script><![endif]-->
    <!--[if !IE]><!-->
    <script src="<?php echo jq('jquery-2.1.1.min.js');?>"></script>
    <!--<![endif]-->
    <link href="<?php echo skin('Css/theme.css');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo skin('Css/dialog.css');?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo jq('ValidForm/validform.js');?>"></script>
    <script src="<?php echo editer('kindeditor.js');?>"></script>
    <script src="<?php echo editer('lang/zh_CN.js');?>"></script>
    <script src="<?php echo skin('Js/common.js');?>"></script>
    <script src="<?php echo skin('Js/artDialog.js');?>"></script>
    <script type="text/javascript">
        $(function () {
            data = $(".form").Validform({
                tiptype: 2,
                callback: function (data) {

                    if (data.status == "y") {
                        location.href = "<?php echo app_url('/article/execution/re/1/message');?>" + data.message;
                    } else {
                        location.href = "<?php echo app_url('/article/execution/re/0/message');?>" + data.message;
                    }
                }
            });
            $("#aprrove" + "," + "#batchDel" + "," + ".attrib_j" + "," + ".attrib_h" + "," + ".attrib_r" + "," + ".attrib_d" + "," + ".attrib_t" + "," + ".attrib_g").bind("click", function () {
                var item = $('input[class="record"]:checked');
                if (item.length == 0) {
                    alert("请选择记录！");
                } else {
                    if (this.id == "batchDel") {
                        if (confirm('是否要删除所选的文章')) {
                            $("#method").val($(this).attr("name"));
                            $("#parameter").val($(this).attr("class"));
                            data.ajaxPost();
                            $.Hidemsg();
                        }
                    } else {
                        $("#method").val($(this).attr("name"));
                        $("#parameter").val($(this).attr("class"));
                        data.ajaxPost();
                        $.Hidemsg();
                    }
                }
            });

            function ajaxChange(field,value,id) {
                htmlobj = $.ajax({
                    url: "<?php echo app_url('/article/ajaxChange/field');?>"+field+'/value/'+value+'/id/'+id+'/',
                    async: false
                });
                var obj = JSON.parse(htmlobj.responseText); //由JSON字符串转换为JSON对象
                $("#"+field+obj.id).val(obj.value);
                $("#"+field+obj.id).after("<span style='color:green'>√</span>");
            }

            $("#outcsv").click(function () {
                var item = $('input[class="record"]:checked');
                if (item.length == 0) {
                    alert("请选择记录！");
                } else {
                    var str = "";
                    item.each(function () {
                        str += $(this).val() + ",";
                    });
                    if (confirm('是否要导出xls文件')) {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo app_url('/article/outCsv');?>",
                            data: {
                                checked : str
                            },
                            success:function(){
                                window.location.href="/Upload/csv/url.xls";
                            }
                        })
                    }
                }
            })

            $("#search").click(function () {
                location.href = "<?php echo app_url('/article/index/field');?>" + $("#field").val() + "/title/" + $("#title").val() + '/';
            });

            $("#shift").click(function () {
                var item = $('input[class="record"]:checked');

                if (item.length == 0) {
                    alert("请选择记录！");
                } else {

                    var str = "";
                    item.each(function () {
                        str += $(this).val() + ",";
                    });

                    $("#siguptitle").text("批量转移");

                    $("#sigupcontent").load('<?php echo app_url("/columns/shift");?>' + "data/" + str);
                    $('.theme-popover-mask').fadeIn(100);
                    $('.theme-popover').slideDown(200);
                }
            });
            $('.theme-poptit .close').click(function () {
                $('.theme-popover-mask').fadeOut(100);
                $('.theme-popover').slideUp(200);
            });
        });
        function artAjax(art_id){
            var dialog = art.dialog({
                title: '医生',
                padding: 10,
                left:0,
                top:0,
                width: '75%'
            });
            $.ajax({
                url: '<?php echo app_url('/article/ajaxReturn/id');?>'+art_id,
                success: function (data) {
                    dialog.content(data);
                }
            });
        }
        function ajaxChange(field,value,id) {
                htmlobj = $.ajax({
                    url: "<?php echo app_url('/article/ajaxChange/field');?>"+field+'/value/'+value+'/id/'+id+'/',
                    async: false
                });
                var obj = JSON.parse(htmlobj.responseText); //由JSON字符串转换为JSON对象
                $("#"+field+obj.id).val(obj.value);
                if($("#"+field+obj.id).next('span').index() > 0 ) return;
                $("#"+field+obj.id).after("<span style='color:green'>√</span>");
        }
    </script>
</head>
<body>
<div id="main">
    <form method="post" action="<?php echo app_url('/article/batch');?>" class="form" name="checkboxform">
        <div id="main_top">
            <dl id="article_ico">
                <dd class="art_ico_1"><a href="<?php echo app_url('/article/add/classid/'.$_GET['classid']);?>">添加文章</a></dd>
                <dd class="art_ico_4"><a href="javascript:;" name="shift" id="shift">批量转移</a></dd>
                <dd class="art_ico_3"><a href="javascript:;" name="batchDel" id="batchDel">批量删除</a></dd>
                <dd class="art_ico_5"><a href="javascript:;" name="aprrove" class="status" id="aprrove">批量审核</a></dd>
                <dd class="art_ico_6"><a href="javascript:;" name="outcsv" class="outcsv" id="outcsv">批量导出</a></dd>
                <?php if($_GET['classid']!=""){?>
                <dd class="art_ico_9"><a href="javascript:history.go(-1)">返回上级</a></dd>
                <?php }?>            </dl>
        </div>
        <div id="art_body" style="padding-top:33px;">
            <div id="art_class">
                <ul>
                    <?php if(($array['article_list']['columns']) && is_array($array['article_list']['columns'])) { foreach($array['article_list']['columns'] as $k => $v) { ?><li class="art_ico_lm">
                        <a href="<?php echo app_url('/article/index/classid/'.$v['id'].'/fid/'.$v['classid']);?>"><?php if($v['pid']==0){?><strong><?php if($v['name']){echo $v['name'];}?></strong><?php } else { ?><span style="border-top: 2px solid red"><?php if($v['name']){echo $v['name'];}?></span><?php }?></a>
                    </li><?php }} ?>                </ul>
            </div>
            <div id="art_list">
                <table cellspacing="0">
                    <tbody>

                    <tr>
                        <th width="40">选择</th>
                        <th style="width:40px; overflow: hidden;">排序</th>
                        <th style="width:40px; overflow: hidden;">序号</th>
                        <th style="width:140px; overflow: hidden;">标题</th>
                        <th style="width:100px; overflow: hidden;">栏目</th>
                        <th style="width:80px; overflow: hidden;">属性</th>
                        <th style="width:80px;  overflow: hidden;">添加/修改日期</th>
                        <th style="width:80px; overflow: hidden;">状态</th>
                        <th width="180">操作</th>
                    </tr>
                    <?php if(($array['article_list']['article']['list']) && is_array($array['article_list']['article']['list'])) { foreach($array['article_list']['article']['list'] as $k => $v) { ?><tr>
                        <td width="40"><input type="checkbox" class="record" id="record<?php echo intval($k+1);?>" name="record[]"
                                              value="<?php if($v['id']){echo $v['id'];}?>"/></td>
                        <td><input type="text" size="5" name="sort" id="sort<?php if($v['id']){echo $v['id'];}?>"
                                   onkeyup="ajaxChange('sort',$(this).val(),<?php if($v['id']){echo $v['id'];}?>)"
                                   value="<?php if($v['sort']){?><?php if($v['sort']){echo $v['sort'];}?><?php } else { ?>0<?php }?>" style="text-align:center; vertical-align:middle" />
                        </td>
                        <td>
                            <?php if($v['id']){echo $v['id'];}?>
                        </td>
                        <td>
                             <span class="art_title_<?php if($v['img']){?>pic<?php } else { ?>txt<?php }?>">
                            <a href="<?php if($v['url']){echo $v['url'];}?>" <?php if($v['status']!=1){?>onClick='alert("文章未通过审核，不能预览");return false;'<?php }?> target="_blank"><?php if($v['title']){echo $v['title'];}?></a></span>
                        </td>
                        <td><?php if($v['columns_name']){echo $v['columns_name'];}?></td>
                        <td>
                            <?php if($v['attrib_j']){?>荐 <?php }?>                            <?php if($v['attrib_g']){?>滚 <?php }?>                            <?php if($v['attrib_t']){?>头 <?php }?>                            <?php if($v['attrib_r']){?>热 <?php }?>                            <?php if($v['attrib_d']){?>顶 <?php }?>                            <?php if($v['attrib_h']){?>幻<?php }?>                        </td>
                        <td><?php if(strpos($v['time'],'-')){?><?php if($v['time']){echo $v['time'];}?><?php } else { ?>                            <?php echo date('Y-m-d',$v['time']);?><?php }?>                        </td>
                        <td>
                            <?php if($v['status']==0){?><span style="color: red">未通过</span><?php }?>                            <?php if($v['status']==1){?><span style="color: #008000">已发布</span><?php }?>                            <?php if($v['status']==2){?>审核中<?php }?>                        </td>
                        <td width="200">
                            <a href="javascript:void(0)" onclick="artAjax(<?php if($v['id']){echo $v['id'];}?>)">预览</a> |
                            <a href="<?php echo app_url('/article/edit/id/'.$v['id']);?>" class="color00f storng">修改</a> |
                            <a href="<?php echo app_url('/article/delete/id/'.$v['id']);?>" class="color999"
                               onClick='return confirm("删除是不可恢复的，你确认要删除<?php if($v['title']){echo $v['title'];}?>吗？");'>删除</a>
                            | <a href="<?php echo app_url('/article/aprrove/id/'.$v['id']);?>">审核</a>
                        </td>
                    </tr><?php }} ?>                    </tbody>
                </table>
            </div>
            <div id="art_sxsz">
                <div id="art_xz"><input type="button" value="全选" id="art_xz_qx" onclick="checkAll()"><input
                        type="button" value="反选" id="art_xz_fx" onclick="switchAll()"><input type="button" value="不选"
                                                                                             id="art_xz_bx"
                                                                                             onclick="uncheckAll()">
                </div>
                <div id="art_sxsz_xz"><strong>设置属性：</strong>
                    [<a href="javascript:void(0)" class="attrib_j" name="attrib">推荐</a>]
                    [<a href="javascript:void(0)" class="attrib_h" name="attrib">幻灯</a>]
                    [<a href="javascript:void(0)" class="attrib_r" name="attrib">热门</a>]
                    [<a href="javascript:void(0)" class="attrib_d" name="attrib">固顶</a>]
                    [<a href="javascript:void(0)" class="attrib_t" name="attrib">头条</a>]
                    [<a href="javascript:void(0)" class="attrib_g" name="attrib">滚动</a>]
                </div>
                <div id="art_sxsz_qq"><strong>取消属性：</strong>
                    [<a href="javascript:void(0)" class="attrib_j" name="attribc">推荐</a>]
                    [<a href="javascript:void(0)" class="attrib_h" name="attribc">幻灯</a>]
                    [<a href="javascript:void(0)" class="attrib_r" name="attribc">热门</a>]
                    [<a href="javascript:void(0)" class="attrib_d" name="attribc">固顶</a>]
                    [<a href="javascript:void(0)" class="attrib_t" name="attribc">头条</a>]
                    [<a href="javascript:void(0)" class="attrib_g" name="attribc">滚动</a>]
                </div>
            </div>
            <div class="h-c-f">
                <div id="art_fenye">
                    <?php if($array['fy']){echo $array['fy'];}?>
                </div>
                <div id="art_so">
                    <span>搜索类型：</span>
                    <select name="field" id="field">
                        <option value="title">标题</option>
                        <option value="tags">关键词</option>
                    </select>
                    <input name="title" id="title" type="text" placeholder="请输入关键词" value="<?php if($_GET['title']){echo $_GET['title'];}?>">
                    <input type="button" id="search" value="立即搜索">
                </div>
            </div>
        </div>
        <input type="hidden" id="method" name="method">
        <input type="hidden" id="parameter" name="parameter">
    </form>
</div>
<div class="theme-popover">
    <div class="theme-poptit">
        <a href="javascript:;" title="关闭" class="close">×</a>

        <h3 id="siguptitle"></h3>

        <div class="dform" id="sigupcontent"></div>
    </div>
</div>
<div class="theme-popover-mask"></div>
</body>
</html>
