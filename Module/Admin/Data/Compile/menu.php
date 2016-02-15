<?php defined('TPL_INCLUDE') OR exit('Access Denied'); ?>
<div id="menu">
    <div class="h-menu">
        <div class="h-menu-t">

            <?php if($array['base'] || $array['dbmanage']){?>
            <div class="menu-box">
                <h2 class="h-xt">系统</h2>
                <?php if($array['base']){?>
                <a href="<?php echo app_url('/base/index');?>" class="t1" target="main"><span>网站基本信息设置</span></a>
                <?php }?>                <?php if($array['dbmanage']){?>
                <a href="<?php echo app_url('/dbmanage/dbbackup');?>" class="t2" target="main"><span>数据库管理</span></a>
                <?php }?>                <strong></strong>
            </div>
            <?php }?>            <?php if($array['article'] || $array['columns'] || $array['link']){?>
            <div class="menu-box">
                <h2 class="h-nr">内容</h2>
                <?php if($array['article']){?>
                <a href="<?php echo app_url('/article/index');?>" class="t1" target="main"><span>文章管理</span></a>
                <?php }?>                <?php if($array['columns']){?>
                <a href="<?php echo app_url('/columns/index');?>" class="t3"  target="main"><span>栏目管理</span></a>
                <?php }?>                <?php if($array['link']){?>
                <a href="<?php echo app_url('/link/index');?>" class="t4" target="main"><span>友情链接</span></a>
                <?php }?>                <?php if($array['tag_link']){?>
                <a href="<?php echo app_url('/tagLink/index');?>" class="t4" target="main"><span>关键词链接</span></a>
                <strong></strong>
                <?php }?>                <strong></strong>
            </div>
            <?php }?>            <?php if($array['member'] || $array['order'] || $array['user'] || $array['power'] || $array['log']){?>
            <div class="menu-box">
                <h2 class="h-yh">用户</h2>
                <?php if($array['user']){?>
                <a href="<?php echo app_url();?>user/index" class="t3" target="main"><span>管理员列表</span></a>
                <?php }?>                <?php if($array['power']){?>
                <a href="<?php echo app_url();?>power/index/" class="t4" target="main"><span>权限组管理</span></a>
                <?php }?>                <?php if($array['log']){?>
                <a href="<?php echo app_url();?>log/index/" class="t5" target="main"><span>系统日志</span></a>
                <?php }?>                <strong></strong>
            </div>
            <?php }?>        </div>
    </div>
</div>
