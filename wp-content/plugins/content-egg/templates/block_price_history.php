<?php
/*
 * Name: Price history
 * Module Types: PRODUCT
 */

__('Price history', 'content-egg-tpl');

defined('\ABSPATH') || exit;


?>

<div class="container py-3 mb-4 mt-1 text-body" <?php $this->colorMode(); ?>>
    <?php $this->renderBlock('price_history'); ?>
</div>