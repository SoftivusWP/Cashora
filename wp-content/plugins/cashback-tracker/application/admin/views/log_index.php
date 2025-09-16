<?php defined('\ABSPATH') || exit; ?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php _e('Logs', 'cashback-tracker'); ?>
    </h1>


    <form id="cashback-tracker-log-table" method="GET">
        <input type="hidden" name="page" value="<?php echo \esc_attr($_REQUEST['page']); ?>"/>
        <?php $table->views(); ?>
        <?php $table->display(); ?>
    </form>
</div>
