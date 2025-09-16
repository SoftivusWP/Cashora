<?php defined('\ABSPATH') || exit; ?>

<?php

use CashbackTracker\application\helpers\TemplateHelper;

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
    jQuery(document).ready(function($) {

        <?php foreach ($advertiser_ids as $advertiser_id) : ?>
            $("div#<?php echo $div_id; ?> .<?php echo \esc_attr($advertiser_id); ?> .cbtrkr_coupon_btn").on("click", function() {
                window.open($(this).attr("data-uri"), '_blank');
                $('div#<?php echo $div_id; ?> .<?php echo \esc_attr($advertiser_id); ?> .cbtrkr_coupon_btn').each(function() {
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

<div id="<?php echo $div_id; ?>" class="cbtrkr_wrap_listing">
    <?php foreach ($coupons as $coupon) : ?>

        <div class="cbtrkr_listing <?php echo \esc_attr($coupon['advertiser_id']); ?>">

            <?php if ($coupon['discount']) : ?>
                <div class="cbtrkr_listing_left">
                    <div class="cbtrkr_listing_orange_color" <?php if (strlen($coupon['discount']) >= 5) : ?> style="font-size: 20px;" <?php endif; ?>>
                        <?php echo \esc_html($coupon['discount']); ?>
                    </div>
                </div>
            <?php elseif ($discount_exists) : ?>
                <div class="cbtrkr_listing_left">
                    <div class="cbtrkr_listing_orange_color">
                        %%
                    </div>
                </div>
            <?php endif; ?>
            <div class="cbtrkr_listing_right">
                <div class="cbtrkr_listing_content">
                    <div class="cbtrkr_listing_title_section">
                        <div class="cbtrkr_listing_title">
                            <?php echo \esc_html(TemplateHelper::truncate($coupon['title'])); ?>
                        </div>
                        <?php if (TemplateHelper::couponConfig('show_description')) : ?>
                            <div class="cbtrkr_listing_description">
                                <?php echo \wp_kses_post(TemplateHelper::truncate($coupon['description'], 1250)); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($coupon['end_date'] && strtotime($coupon['end_date']) && TemplateHelper::couponConfig('show_exp_date')) : ?>
                            <div class="cbtrkr_listing_time">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="12" height="12" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                <?php if ($coupon['end_date']) echo sprintf(__('Expires on: %s', 'cashback-tracker'), TemplateHelper::dateFormatFromGmt($coupon['end_date'], false)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="cbtrkr_coupon_section">
                    <?php if ($coupon['code']) : ?>
                        <span data-uri="<?php echo \esc_url($coupon['link']); ?>" class="cbtrkr_coupon_btn">
                            <div class="cbtrkr_coupon_hidden_code" data-code="<?php echo \esc_attr($coupon['code']); ?>"></div>
                            <div class="cbtrkr_coupon_btn_txt"><?php TemplateHelper::btnTextCoupon(); ?></div>
                        </span>
                    <?php else : ?>
                        <a href="<?php echo \esc_url($coupon['link']); ?>" target="_blank" rel="nofollow sponsored" class="cbtrkr_coupon_btn_deal">
                            <?php TemplateHelper::btnTextDeal(); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($a['display_domain']) && isset($coupon['adv_domain'])) : ?>
                        <div class="cbtr_merchant_wrap"><span class="cbtr_merchant_text"><?php echo \esc_html(ucfirst($coupon['adv_domain'])); ?></span></div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>