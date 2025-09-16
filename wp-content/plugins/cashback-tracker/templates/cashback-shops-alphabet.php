<?php defined('\ABSPATH') || exit;
$this->enqueueFrontendStyle();
$this->enqueueFrontendScript();
$imagestyle = ($a['imageheight'] != 60) ? ' style="max-height:' . $a['imageheight'] . 'px"' : '';
$imageblockheight = $a['imageheight'] + 40;
$imageblockstyle = ($a['imageheight'] != 60) ? ' style="height:' . $a['imageheight'] . 'px"' : '';
?>


<?php
$shop_pages = CashbackTracker\application\helpers\TemplateHelper::sortPagesByName($shop_pages);
$groups = array();
$first_letters = array();
foreach ($shop_pages as $shop_page)
{
    $viewer = \CashbackTracker\application\components\AdvertiserViewer::getInstance($shop_page->ID);
    if ($name = $viewer->getName())
        $shop_name = $name;
    else
        $shop_name = $shop_page->post_title;

    $first_letter = mb_strtoupper(mb_substr($shop_name, 0, 1), 'utf-8');
    if (!isset($first_letters[$first_letter]))
        $first_letters[$first_letter] = $first_letter;
    if (!isset($groups[$first_letter]))
        $groups[$first_letter] = array();
    $groups[$first_letter][] = $shop_page;
}
?>

<div class="<?php echo \esc_attr($a['wrapclass']); ?>">        
    <div class="cbtrkr_alpha_head" id="cbtrkr_alpha_menu">
        <div class="cbtrkr_list_inline">
            <?php foreach ($first_letters as $fl): ?>
                <span data-scrollto="#<?php echo \esc_attr($fl); ?>" class="cbtrkr_scroll"><?php echo \esc_html($fl); ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach ($first_letters as $fl): ?>
        <div class="cbtrkr_alpha_body">
            <div class="cbtrkr_alpha_letter">
                <span id="<?php echo \esc_attr($fl); ?>"></span>
                <div class="cbtrkr_letter_tag"><?php echo \esc_html($fl); ?>
                    <div class="cbtrkr_return">
                        <span class="cbtrkr_scroll" data-scrollto="#cbtrkr_alpha_menu">&#x2191;</span>
                    </div>
                </div>
            </div>
            <div class="cbtrkr_grid cbtrkr_flex">
                <?php foreach ($groups[$fl] as $first_letter => $shop_page): ?>
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
                <?php for ($i = 0; $i < ceil(count($groups[$fl]) / $a['cols']) * $a['cols'] - count($groups[$fl]); $i++): ?>                
                    <div class="cbtrkr_emptyheight cbtrkr_cols_<?php echo \esc_attr($a['cols']); ?>"></div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>