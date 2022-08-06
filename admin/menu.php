<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<div class="typecho-head-nav clearfix" role="navigation">
    <nav id="typecho-nav-list">
        <?php $menu->output(); ?>
    </nav>
    <div class="operate">
        <?php Typecho_Plugin::factory('admin/menu.php')->navBar(); ?>
        <a class="exit" href="<?php $options->logoutUrl(); ?>"><?php _e('登出'); ?></a><a href="<?php $options->siteUrl(); ?>"><?php _e('网站'); ?></a>
    </div>
</div>

