<div class="circle-text first cus-border border-1 b-second p2-bg-color d-center cus-z1 tp-el-text-wrapper">
    <?php if( !empty( $settings['experience_text'] ) ) : ?>
    <div class="text">
        <p class="fs-seven text-uppercase n1-color tp-el-text"><?php echo esc_html( $settings['experience_text'] ); ?></p>
    </div>
    <?php endif; ?>
    <?php if( !empty( $settings['experience_year'] ) ) : ?>
    <div class="img-area p1-bg-color d-center position-relative rounded-circle cus-border tp-el-number-wrapper">
        <span class="heading fs-two s1-color position-absolute tp-el-number"><?php echo esc_html( $settings['experience_year'] ); ?></span>
    </div>
    <?php endif; ?>
</div>