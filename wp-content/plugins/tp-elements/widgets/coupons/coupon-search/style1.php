<div class="tp-coupon-search-area">
    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" id="coupon-search-form">
        <div class="tp-coupn-search ">
            <div class="tp-coupn-search-input-wrapper position-relative">
                <input type="text" name="s" placeholder="<?php echo esc_attr__('Find Coupon...', 'tp-elements'); ?>" class="tp-coupn-search-input" id="coupon-search-input" value="<?php echo get_search_query(); ?>">
                <button type="submit" class="tp-coupn-search-btn"><i class="tp tp-search"></i></button>
            </div>
            <input type="hidden" name="post_type" value="coupon"> <!-- Hidden field to restrict search to 'coupon' post type -->
        </div>
    </form>
    <!-- Container for displaying live coupon suggestions -->
    <div id="coupon-search-results" class="d-none"></div>
</div>
