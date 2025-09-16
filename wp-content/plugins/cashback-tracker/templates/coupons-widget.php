<?php
defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\TemplateHelper;

$this->enqueueFrontendStyle();

\wp_enqueue_script('jquery');

$div_id = 'cbtrkr_coupons_' . rand(1, 99999);

$advertiser_ids = array();
$discount_exists = false;
foreach ($coupons as $coupon)
{
    $advertiser_ids[$coupon['advertiser_id']] = $coupon['advertiser_id'];
    if ($coupon['discount'])
        $discount_exists = true;
}
?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {

<?php foreach ($advertiser_ids as $advertiser_id): ?>
            $("div#<?php echo $div_id; ?> .<?php echo \esc_attr($advertiser_id); ?> .cbtrkr_coupon_btn").on("click", function () {
                window.open($(this).attr("data-uri"), '_blank');
                $('div#<?php echo $div_id; ?> .<?php echo \esc_attr($advertiser_id); ?> .cbtrkr_coupon_btn').each(function () {
                    var btn_txt = $(this).find('.cbtrkr_coupon_btn_txt');
                    btn_txt.css("visibility", "hidden");
                    btn_txt.css("pointer-events", "none");
                    var code = $(this).find('.cbtrkr_coupon_hidden_code');
                    code.html(code.attr("data-code"));
                    code.removeAttr("data-code");
                    code.css("text-align", "center");
                    $(this).off("click");
                });
            });

<?php endforeach; ?>

    });
</script>


<div id="<?php echo $div_id; ?>">
    <?php foreach ($coupons as $coupon): ?>

        <div class="cbtrkr_flex cbtrkr_flex_no_wrap cbtrkr_widget_item <?php echo \esc_attr($coupon['advertiser_id']); ?>">
            <?php if ($coupon['discount']): ?>

                <div class="cbtrkr_listing_left">
                    <div class="cbtrkr_listing_orange_color"<?php if (strlen($coupon['discount']) >= 5): ?> style="font-size: 16px;"<?php endif; ?>><?php echo \esc_html($coupon['discount']); ?></div>
                </div>
            <?php elseif ($discount_exists): ?>

                <div class="cbtrkr_listing_left">
                    <div class="cbtrkr_listing_orange_color">%%</div>
                </div>            
            <?php endif; ?>


            <div class="cbtrkr_listing_right">
                <div class="cbtrkr_listing_content">
                    <div class="cbtrkr_listing_title_section">
                        <div class="cbtrkr_listing_title">
                            <?php echo \esc_html(TemplateHelper::truncate($coupon['title'])); ?>
                        </div>
                    </div>

                    <div class="cbtrkr_coupon_section">
                        <?php if ($coupon['code']): ?>
                            <span data-uri="<?php echo \esc_url($coupon['link']); ?>" class="cbtrkr_coupon_btn">
                                <div class="cbtrkr_coupon_hidden_code" data-code="<?php echo esc_attr($coupon['code']); ?>"></div>
                                <div class="cbtrkr_coupon_btn_txt"><?php TemplateHelper::btnTextCoupon(); ?></div>
                            </span>
                        <?php else: ?>
                            <a href="<?php echo \esc_url($coupon['link']); ?>" target="_blank" rel="nofollow sponsored" class="cbtrkr_coupon_btn_deal">
                                <?php TemplateHelper::btnTextDeal(); ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($a['display_domain']) && !empty($coupon['adv_domain'])): ?>
                            <div class="cbtr_merchant_wrap"><span class="cbtr_merchant_text"><?php echo \esc_html(ucfirst($coupon['adv_domain'])); ?></span></div>
                            <?php endif; ?>

                    </div>                    

                </div>

            </div>
        </div>     


    <?php endforeach; ?>
</div>



