<div class="tp-coupon-search-area">
    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" id="coupon-search-form">
        <div class="tp-coupn-search position-relative">
            <select class="tp-coupon-category" id="coupon-category-select">
                <option value=""><?php echo esc_html__('Select Category', 'tp-elements'); ?></option> <!-- Default empty option -->
                <?php 
                    $coupon_cats = get_terms( array(
                        'taxonomy'    => 'coupon-category',
                        'hide_empty'  => true            
                    ) );

                    if ($coupon_cats && !is_wp_error($coupon_cats)) {
                        foreach ($coupon_cats as $category) {
                            $category_name = $category->name;
                            $category_slug = $category->slug; // Get the category slug to use as value
                            echo '<option value="' . $category_slug . '">' . $category_name . '</option>';
                        }
                    }        
                ?>
            </select>
            <div class="tp-coupn-search-input-wrapper position-relative">
                <input type="text" name="s" placeholder="<?php echo esc_attr__('Find Coupon...', 'tp-elements'); ?>" class="tp-coupn-search-input" id="coupon-search-input" value="<?php echo get_search_query(); ?>">
                <button type="submit" class="tp-coupn-search-btn"><?php echo esc_html__('Search', 'tp-elements'); ?></button>
            </div>
        </div>
        <input type="hidden" name="post_type" value="coupon"> <!-- Hidden field to restrict search to 'coupon' post type -->
    </form>

    <!-- Container for displaying live coupon suggestions -->
    <div id="coupon-search-results" class="d-none"></div>
</div>
