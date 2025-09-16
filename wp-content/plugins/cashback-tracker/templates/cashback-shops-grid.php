<?php defined('\ABSPATH') || exit;
$this->enqueueFrontendStyle();
$imagestyle = ($a['imageheight'] != 60) ? ' style="max-height:' . $a['imageheight'] . 'px"' : '';
$imageblockheight = $a['imageheight'] + 40;
$imageblockstyle = ($a['imageheight'] != 60) ? ' style="height:' . $a['imageheight'] . 'px"' : '';
?>

<div class="<?php echo \esc_attr($a['wrapclass']); ?>">        
    <div class="cbtrkr_grid cbtrkr_flex">
        <?php foreach ($shop_pages as $shop_page): ?>
            <?php $viewer = \CashbackTracker\application\components\AdvertiserViewer::getInstance($shop_page->ID); ?>
            <a class="cbtrkr_grid_item cbtrkr_cols_<?php echo \esc_attr($a['cols']); ?> cbtrkr_cols_mob_2 <?php echo \esc_attr($a['classitem']); ?>" href="<?php echo \get_the_permalink($shop_page->ID); ?>">
                <div class="cbtrkr_grid_image cbtrkr_center_inside"<?php echo $imageblockstyle; ?>>
                    <?php if ($logo = $viewer->getLogoUrl()): ?>
                        <img src="<?php echo \esc_attr($logo); ?>" alt="<?php echo \esc_attr($viewer->getName()); ?>"<?php echo $imagestyle; ?>>
                    <?php endif; ?>
                </div>
                <div class="cbtrkr_grid_name"><?php echo \esc_html($viewer->getName()); ?></div>
                <div class="cbtrkr_grid_cashback">
                    <?php if ($cashback = $viewer->getCashback()): ?>
                        <span class="cbtrkr_grid_cashback_val"><?php echo \esc_html($cashback); ?></span>
                        <span class="cbtrkr_grid_cashback_lbl"><?php _e('Cash Back', 'cashback-tracker'); ?></span>
                    <?php endif; ?>                            
                </div>
            </a>
        <?php endforeach; ?>
        <?php for ($i = 0; $i < ceil(count($shop_pages) / $a['cols']) * $a['cols'] - count($shop_pages); $i++): ?>
            <div class="cbtrkr_emptyheight cbtrkr_cols_<?php echo \esc_attr($a['cols']); ?>"></div>
        <?php endfor; ?>
    </div>
</div>