<?php

defined('\ABSPATH') || exit;
$this->enqueueFrontendStyle();
?>


<?php echo $this->render('_coupon_list', array('coupons' => $coupons, 'a' => $a)); ?>
    

