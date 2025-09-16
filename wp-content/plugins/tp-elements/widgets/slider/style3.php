<div class="swiper-slide tp-slide-item">
    <div class="vision-main-wrapper">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="side-sticky">
                    <div class="sticky-inner">
                        <div class="thumbnail-area-about">
                            <img class="banner-img" src="<?php echo esc_url($image); ?>" alt="image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 about-a-p-cont col-md-6">
                <div class="about-inner-wrapper-inner">
                    <div class="title-three-left">
                        <h2 class="slider-title">
                            <?php echo wp_kses_post($title); ?>
                        </h2>
                    </div>
                    <div class="main-content-area-about-p">
                        <div class="disc">
                        <?php echo wp_kses_post($description); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>