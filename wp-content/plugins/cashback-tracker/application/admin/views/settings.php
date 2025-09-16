<?php defined('\ABSPATH') || exit; ?>
<?php
/*
 * Некоторые иконы Yusuke Kamiyamane. Доступно по лицензии Creative Commons Attribution 3.0.
 * @link: http://p.yusukekamiyamane.com
 */
?>
<?php \wp_enqueue_script('cbtrkr-blockUI', \CashbackTracker\PLUGIN_RES . '/js/jquery.blockUI.js', array('jquery')); ?>
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
    <h2>
        <?php _e('Cashback Tracker Settings', 'cashback-tracker'); ?>
        <?php if (\CashbackTracker\application\Plugin::isPro()): ?>
            <span class="cbtrkr-pro-label">pro</span>
        <?php endif; ?>
    </h2>

    <?php $modules = \CashbackTracker\application\components\ModuleManager::getInstance()->getConfigurableModules(); ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=cashback-tracker" 
           class="nav-tab<?php if (!empty($_GET['page']) && $_GET['page'] == 'cashback-tracker') echo ' nav-tab-active'; ?>">
               <?php _e('General settings', 'cashback-tracker'); ?>
        </a>
        <a href="?page=cashback-tracker-coupon" 
           class="nav-tab<?php if (!empty($_GET['page']) && $_GET['page'] == 'cashback-tracker-coupon') echo ' nav-tab-active'; ?>">
               <?php _e('Coupons', 'cashback-tracker'); ?>
        </a>        
        <?php foreach ($modules as $m): ?>
            <?php $config = $m->getConfigInstance(); ?>
            <a href="?page=<?php echo esc_attr($config->page_slug()); ?>" 
               class="nav-tab<?php if (!empty($_GET['page']) && $_GET['page'] == $config->page_slug()) echo ' nav-tab-active'; ?>">

                <?php
                if ($m->isActive() && $m->isDeprecated())
                    $status = 'deprecated';
                elseif ($m->isActive())
                    $status = 'active';
                else
                    $status = 'inactive';
                ?>

                <img src="<?php echo \CashbackTracker\PLUGIN_RES; ?>/img/status-<?php echo $status; ?>.png" />
                <?php echo esc_html($m->getName()); ?><?php if ($m->isCashebackModule()): ?> Cashback<?php endif; ?>
                <?php if ($m->isNew()): ?><img src="<?php echo \CashbackTracker\PLUGIN_RES; ?>/img/new.png" alt="New" title="New" /><?php endif; ?>                    
            </a>

        <?php endforeach; ?>
    </h2> 

    <div class="ui-sortable meta-box-sortables">
        <div class="postbox1">
            <div class="inside">
                <h3 class="wp-heading-inline" style="display: inline-block;">
                    <?php
                    if (!empty($_GET['page']) && $_GET['page'] == 'cashback-tracker')
                        _e('General settings', 'cashback-tracker');
                    elseif (!empty($_GET['page']) && $_GET['page'] == 'cashback-tracker-coupon')
                        _e('Coupon settings', 'cashback-tracker');
                    else
                        echo \esc_html($header);
                    ?> 
                </h3>
                <?php if (!empty($module) && $module->isActive() && $download_date = \CashbackTracker\application\components\AdvertiserManager::getInstance()->getDownloadDate($module->getId())): ?>
                    <?php $adv_count = \CashbackTracker\application\components\AdvertiserManager::getInstance()->advertiserCount($module->getId()); ?>                
                    <span style="margin-left: 15px;">
                        <?php echo sprintf(__('Joined advertisers: %d as of %s', 'cashback-tracker'), $adv_count, \CashbackTracker\application\helpers\TemplateHelper::formatDateHumanReadable($download_date)); ?>
                        [ <a class="cbtrkr_show_waiting_box" href="<?php echo \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-tools&action=refresh-advertisers&module_id=' . urlencode($module->getId())) ?>"><?php echo __('refresh', 'cashback-tracker') ?></a>

                        |         <a href="<?php echo \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-tools&action=refresh-advertisers-cron&module_id=' . urlencode($module->getId())); ?>">
                            <?php _e('refresh in background', 'cashback-tracker'); ?>
                        </a>

                        ]
                    </span>
                <?php endif; ?>
                <br />

                <?php if (!empty($module) && $module->isDeprecated()): ?>
                    <div class="cbtrkr-warning">  
                        <strong>
                            <?php _e('WARNING:', 'cashback-tracker'); ?>
                            <?php _e('This module is deprecated.', 'cashback-tracker'); ?>
                        </strong>
                    </div>
                <?php endif; ?>

                <?php settings_errors(); ?>    

                <?php if (!empty($module) && $module->isActive() && $module->isCashebackModule()): ?>

                    <a class="button button-primary cbtrkr_show_waiting_box" href="<?php echo \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-tools&action=download-offers&module_id=' . urlencode($module->getId())) ?>">
                        <?php _e('Download orders', 'cashback-tracker'); ?>
                    </a>

                <?php endif; ?>

                <form action="options.php" method="POST">
                    <?php settings_fields($page_slug); ?>
                    <table class="form-table">
                        <?php //do_settings_fields($page_slug, 'default'); ?>
                        <?php do_settings_sections($page_slug); ?> 									
                    </table>        
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>
    </div>   
</div>
