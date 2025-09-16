<div class="pixelaxis-breadcrumbs">
    <?php
    global $cashora_option;
    if (!empty($cashora_option['blog_banner_main']['url'])) { ?>
        <div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url($cashora_option['blog_banner_main']['url']); ?>')">
        <?php } elseif (!empty($cashora_option['breadcrumb_bg_color'])) { ?>
            <div class="breadcrumbs-single" style="background:<?php echo esc_attr($cashora_option['breadcrumb_bg_color']); ?>">
            <?php } else { ?>
                <div class="breadcrumbs-single">
                <?php } ?>
                <div class="pixelaxis-breadcrumbs-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="breadcrumbs-inner">
                                    <h1 class="page-title"><?php printf(__('Search Results for: %s', 'deala'), '<span>' . get_search_query() . '</span>'); ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>