<?php
defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\TemplateHelper;
use CashbackTracker\application\components\TemplateManager;

/**
 * The Template for displaying all single advertiser pages.
 * This template can be overridden by copying it to yourtheme/single-cashback-shop.php
 *
 */
if (!defined('ABSPATH'))
    exit;

$viewer = TemplateHelper::getAdvertiserViewer(get_the_ID());
$cashback = $viewer->getCashback();
$name = $viewer->getName();
$validation_days = $viewer->getValidationDays();
$tracking_link = $viewer->getTrackingLink();
$gotoshop_button_class = TemplateHelper::getGotoshopButtonClass();

if (\CashbackTracker\application\admin\GeneralConfig::getInstance()->option('cashback_section') != 'disabled')
    $go_shop_link = TemplateHelper::getGoShopLink($tracking_link);
else
    $go_shop_link = $tracking_link;

get_header('cashback-shop');
?>

<div class="cbtrkr_single_container">
    <div class="cbtrkr_single_wrapper">
        <div class="cbtrkr_single_sidebar">
            <div class="cbtrkr_single_img cbtrkr_center_inside">

                <?php if (has_post_thumbnail()) : ?>
                    <div>
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($go_shop_link): ?>
                <a rel="nofollow" href="<?php echo \esc_url($go_shop_link); ?>" class="cbtrkr_btn_goshop<?php echo \esc_attr($gotoshop_button_class); ?>" data-url="<?php echo \esc_attr($tracking_link); ?>" data-cashbacknotice="<?php echo esc_attr(sprintf(__('%s Cash Back', 'cashback-tracker'), $cashback)); ?>" data-merchant="<?php echo esc_attr($name); ?>">
                    <?php _e('Go to shop', 'cashback-tracker'); ?>
                </a>
            <?php endif; ?>

            <?php if (\CashbackTracker\application\admin\GeneralConfig::getInstance()->option('cashback_section') != 'disabled'): ?>
                <div class="cbtrkr_cashback_notice">
                    <div class="cbtrkr_cashback_notice_merchant"><?php echo esc_html($name); ?></div>
                    <div class="cbtrkr_cashback_notice_title"><?php _e('Cashback', 'cashback-tracker'); ?></div>

                    <?php if ($viewer->getModuleId() == 'Linkwise'): ?>
                        <?php echo TemplateManager::getInstance()->render('_cashback_linkwise', array('viewer' => $viewer)); ?>
                    <?php else: ?>
                        <div class="cbtrkr_cashback_notice_value"><?php echo esc_html($cashback); ?></div>
                    <?php endif; ?>

                    <div class="cbtrkr_cashback_notice_divider"></div>
                    <?php if ($validation_days): ?>
                        <div class="cbtrkr_cashback_notice_title"><?php _e('Average approve time', 'cashback-tracker'); ?></div>
                        <div class="cbtrkr_cashback_notice_value"><?php echo sprintf(__('%d days'), $viewer->getValidationDays()); ?></div>				
                    <?php endif; ?>
                </div>	
            <?php endif; ?>

            <?php if ($area = TemplateHelper::getAreaSidebar(get_the_ID())): ?>
                <div class="post">                
                    <div class="cbtrkr_cashback_side_add">
                        <?php echo $area; ?>
                    </div>		
                </div>
            <?php endif; ?>

            <div class="widget cbtrkr_widget" style="padding-top: 15px;">
                <?php echo \do_shortcode('[cashback-shops limit="6" type="widget" cols="2"]'); ?>
            </div>
        </div>
        <div class="cbtrkr_single_content">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <h1 class="entry-title"><?php the_title(); ?></h1>

                        <?php the_content(); ?>

                        <?php
                        if (comments_open() || get_comments_number())
                        {
                            comments_template();
                        }
                        ?>
                        <?php
                    endwhile;
                endif;
                ?>
            </article>

        </div>


    </div>
</div>
<!-- END OF SINGLE CONTAINER -->

<?php
get_footer('cashback-shop');
