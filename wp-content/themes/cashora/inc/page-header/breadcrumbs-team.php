<?php
global $cashora_option;
$header_width_meta = get_post_meta(get_the_ID(), 'header_width_custom', true);
if ($header_width_meta != '') {
    $header_width = ($header_width_meta == 'full') ? 'container-fluid' : 'container';
} else {
    $header_width = !empty($cashora_option['header-grid']) ? $cashora_option['header-grid'] : '';
    $header_width = ($header_width == 'full') ? 'container-fluid' : 'container';
}
$post_meta_data = get_post_meta(get_the_ID(), 'banner_image', true);
$post_menu_type = get_post_meta(get_the_ID(), 'menu-type', true);
$content_banner = get_post_meta(get_the_ID(), 'content_banner', true);
$intro_content_banner = get_post_meta(get_the_ID(), 'intro_content_banner', true);
?>
<div class="pixelaxis-breadcrumbs">
    <?php if ($post_meta_data != '') { ?>
        <div class="breadcrumbs-single" style="background:<?php echo esc_attr($cashora_option['breadcrumb_bg_color']); ?>">
            <img src="<?php echo esc_url($post_meta_data); ?>" alt="<?php echo esc_attr__('breadcrumb image', 'deala'); ?>">
            <div class="container">
                <div class="row">

                    <div class="breadcrumbs-inner bread-<?php echo esc_attr($post_menu_type); ?>">
                        <div class="row gap-2">
                            <div class="col-12">
                                <?php
                                $post_meta_title = get_post_meta(get_the_ID(), 'select-title', true); ?>
                                <?php if ($post_meta_title != 'hide') {
                                ?>
                                    <?php if (!empty($cashora_option['team_page_subtitle'])) : ?>
                                        <span class="sub-title"><?php echo esc_html($cashora_option['team_page_subtitle']); ?></span>
                                    <?php endif; ?>
                                    <h1 class="page-title">
                                        <?php if (!empty($cashora_option['team_page_title'])) {
                                            echo esc_html($cashora_option['team_page_title']);
                                        } else {
                                            echo esc_html('Team Details', 'deala');
                                        }
                                        ?>
                                    </h1>
                                <?php }

                                ?>
                                <?php if (!empty($cashora_option['off_breadcrumb'])) {
                                    $rs_breadcrumbs = get_post_meta(get_the_ID(), 'select-bread', true);
                                    if ($rs_breadcrumbs != 'hide'):
                                        if (function_exists('bcn_display')) { ?>
                                            <div class="breadcrumbs-title"> <?php bcn_display(); ?></div>
                                <?php }
                                    endif;
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif (!empty($cashora_option['team_single_image']['url'])) { ?>
        <div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url($cashora_option['team_single_image']['url']); ?>')">
            <div class="container">
                <div class="breadcrumbs-inner bread-<?php echo esc_attr($post_menu_type); ?>">
                    <div class="row gap-2">
                        <div class="col-12">
                            <?php
                            $post_meta_title = get_post_meta(get_the_ID(), 'select-title', true); ?>
                            <?php if ($post_meta_title != 'hide') {
                            ?>
                                <?php if (!empty($cashora_option['team_page_subtitle'])) : ?>
                                    <span class="sub-title"><?php echo esc_html($cashora_option['team_page_subtitle']); ?></span>
                                <?php endif; ?>
                                <h1 class="page-title">
                                    <?php if (!empty($cashora_option['team_page_title'])) {
                                        echo esc_html($cashora_option['team_page_title']);
                                    } else {
                                        echo esc_html('Team Details', 'deala');
                                    }
                                    ?>
                                </h1>
                            <?php }
                            ?>
                            <?php if (!empty($cashora_option['off_breadcrumb'])) {
                                $rs_breadcrumbs = get_post_meta(get_the_ID(), 'select-bread', true);
                                if ($rs_breadcrumbs != 'hide'):
                                    if (function_exists('bcn_display')) { ?>
                                        <div class="breadcrumbs-title"> <?php bcn_display(); ?></div>
                            <?php }
                                endif;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="breadcrumbs-single" style="background:<?php echo esc_attr($cashora_option['breadcrumb_bg_color']); ?>">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumbs-inner bread-<?php echo esc_attr($post_menu_type); ?>">

                            <?php
                            $post_meta_title = get_post_meta(get_the_ID(), 'select-title', true); ?>
                            <?php if ($post_meta_title != 'hide') {
                            ?>
                                <h1 class="page-title">
                                    <?php if ($content_banner != '') {
                                        echo esc_html($content_banner);
                                    } else {
                                        echo esc_html('Team Details', 'deala');
                                    }
                                    ?>
                                </h1>
                            <?php }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>