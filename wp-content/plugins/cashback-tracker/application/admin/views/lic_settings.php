<?php defined('\ABSPATH') || exit; ?>
<div class="wrap">

    <h2><?php echo sprintf(__('%s license', 'cashback-tracker'), \CashbackTracker\application\Plugin::getName()); ?></h2>

    <?php settings_errors(); ?>
    <form action="options.php" method="POST">
        <?php \settings_fields($page_slug); ?>
        <table class="form-table">
            <?php \do_settings_fields($page_slug, 'default'); ?>
        </table>
        <?php \submit_button(__('Activate license', 'cashback-tracker')); ?>
    </form>

    <?php if (\CashbackTracker\application\Plugin::isActivated()): ?>
        <h2><?php _e('Deactivate license', 'cashback-tracker'); ?></h2>
        <?php _e('You can transfer your license to another domain.', 'cashback-tracker'); ?>
        <br>
        <br>
        <form action="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=' . \CashbackTracker\application\Plugin::getSlug() . '-lic'); ?>" method="POST">
            <input type="hidden" name="cmd" id="cmd" value="lic_reset"  />            
            <input type="hidden" name="nonce_reset" value="<?php echo \wp_create_nonce('license_reset'); ?>"/>
            <input type="submit" name="submit2" id="submit2" class="button submitdelete deletion" value="<?php _e('Deactivate license', 'cashback-tracker'); ?>"  />
        </form>
    <?php endif; ?>    
</div>