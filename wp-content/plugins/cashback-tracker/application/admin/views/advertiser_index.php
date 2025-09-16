<?php defined('\ABSPATH') || exit; ?>
<div id="cbtrkr_waiting_box" style="display:none; text-align: center;"> 
    <h2><?php _e('Working... Please wait...', 'cashback-tracker'); ?></h2> 
    <p>
        <img src="<?php echo \CashbackTracker\PLUGIN_RES; ?>/img/waiting.gif" />
    </p>
</div>
<script type="text/javascript">
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
        $j('.cbtrkr_show_waiting_box').click(function () {
            $j.blockUI({message: $j('#cbtrkr_waiting_box')});
        });
    });
</script>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php _e('Advertisers', 'cashback-tracker'); ?>
        <a id="btn_refresh_all_advertisers" class="page-title-action cbtrkr_show_waiting_box" href="<?php echo \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-tools&action=refresh-all-advertisers'); ?>">
            <?php _e('Refresh all advertisers', 'cashback-tracker'); ?>
        </a>
        
        <a id="btn_create_pages" class="page-title-action cbtrkr_show_waiting_box" href="<?php echo \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-tools&action=create-all-pages'); ?>">
            <?php _e('Create all pages', 'cashback-tracker'); ?>
        </a>        
    </h1>

    <form id="order-table" method="GET">
        <input type="hidden" name="page" value="<?php echo \esc_attr($_REQUEST['page']); ?>"/>
        <?php $table->views(); ?>
        <?php $table->display(); ?>
    </form>
</div>
