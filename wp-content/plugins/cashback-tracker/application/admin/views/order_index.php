<?php defined('\ABSPATH') || exit; ?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php _e('Orders', 'cashback-tracker'); ?>
    </h1>


    <form id="order-table" method="GET">
        <input type="hidden" name="page" value="<?php echo \esc_attr($_REQUEST['page']); ?>"/>
        <?php if (isset($_REQUEST['order_status'])): ?>
            <input type="hidden" name="order_status" value="<?php echo \esc_attr($_REQUEST['order_status']); ?>"/>
        <?php endif; ?>
        <?php $table->views(); ?>
        <?php $table->search_box(__('Search order', 'cashback-tracker'), 'key'); ?>            
        <?php $table->display(); ?>
    </form>
</div>
