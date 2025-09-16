<?php
defined('\ABSPATH') || exit;
$this->enqueueFrontendStyle();

$cols = (int) $a['cols'];
if ($cols < 1 || $cols > 6)
    $cols = 3;

$cols_mob = ceil($cols / 2);
?>


<div class="cbtrkr_merchants_wrap">        
    <div class="cbtrkr_grid cbtrkr_flex">

        <?php foreach ($shop_pages as $shop_page): ?>

            <?php $viewer = \CashbackTracker\application\components\AdvertiserViewer::getInstance($shop_page->ID); ?>

            <a class="cbtrkr_grid_item cbtrkr_cols_<?php echo $cols;?> cbtrkr_cols_mob_<?php echo $cols_mob;?>" href="<?php echo \get_the_permalink($shop_page->ID); ?>">
                
                <?php $logo = $viewer->getLogoUrl(); ?>
                <?php if ($logo): ?>
                    <div class="cbtrkr_grid_image cbtrkr_center_inside">
                        <img src="<?php echo \esc_attr($logo); ?>" alt="<?php echo \esc_attr($viewer->getName()); ?>">
                    </div>
                <?php endif; ?>

                <?php if (!$logo): ?>
                    <div class="cbtrkr_grid_name cbtrkr_grid_image cbtrkr_center_inside" style="font-size: 10px;"><?php echo \esc_html(ucfirst($viewer->getDomain())); ?></div>
                <?php endif; ?>

            </a>
        <?php endforeach; ?>
        
    </div>

</div>