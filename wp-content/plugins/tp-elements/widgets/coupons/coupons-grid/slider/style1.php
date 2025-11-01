<div class="swiper-slide grid-item " >

    <div class="themephi-addon-coupons position-relative <?php echo esc_attr( $settings['image_or_icon_vertical_align'] ); ?> <?php echo esc_attr( $settings['image_or_icon_position'] ); ?> coupons-<?php echo esc_attr( $settings['coupon_style'] ); ?> coupons-<?php echo esc_attr( $settings['coupon_grid_source'] ); ?>">

        <div class="tp-coupon-item-wrapper">
            <?php if( $settings['show_top_meta'] == 'yes' && $settings['show_top_meta_position'] == 'yes' ) : ?>
            <div class="tp-coupon-meta d-flex flex-wrap ">
                <span class="tp-coupon-meta-left d-inline-flex">
                    <?php if( !empty( $exclusive ) && $settings['coupon_exclusive_show_hide'] == 'yes' && $settings['show_top_meta'] == 'yes' ) : ?>
                    <span class="tp-coupon-meta-single-upper tp-coupon-meta-exclusive"><?php echo esc_html__( 'Exclusive', 'tp-elements' ); ?></span>
                    <?php endif; ?>
                    <?php 
                    if( $settings['coupon_available_show_hide'] == 'yes' && $settings['show_top_meta'] == 'yes' ) {
                        if ( $expire_timestamp ) {
                            $current_timestamp = current_time( 'timestamp' );
                            if ( $expire_timestamp > $current_timestamp ) {
                                echo '<span class="tp-coupon-meta-single-upper tp-coupon-meta-exclusive"><i class="tp tp-check-1"></i> Available </span>';
                            } else {
                                echo '<span class="tp-coupon-meta-single-upper tp-coupon-meta-exclusive"> Expired </span>';
                            }
                        }
                    }              
                    ?>
                </span>
                <div class="tp-coupon-meta-right d-inline-flex">

                    <?php if( $settings['coupon_favourite_show_hide'] == 'yes' && $settings['show_top_meta'] == 'yes' ) : ?>
                    <span class="tp-coupon-meta-single-upper favorite-bookmark" data-coupon-id="<?php echo esc_attr( get_the_ID() ); ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.9066 5.3445C19.8877 4.32811 18.5077 3.75655 17.0685 3.75479C15.6294 3.75303 14.248 4.32123 13.2266 5.33512L12.0004 6.47419L10.7732 5.33137C9.752 4.31307 8.36814 3.74212 6.92602 3.74415C5.48389 3.74617 4.10163 4.32099 3.08333 5.34216C2.06502 6.36332 1.49408 7.74718 1.4961 9.18931C1.49812 10.6314 2.07294 12.0137 3.09411 13.032L11.4707 21.5314C11.5405 21.6022 11.6236 21.6585 11.7154 21.6969C11.8071 21.7353 11.9056 21.7551 12.005 21.7551C12.1045 21.7551 12.203 21.7353 12.2947 21.6969C12.3864 21.6585 12.4696 21.6022 12.5394 21.5314L20.9066 13.032C21.9256 12.0124 22.4981 10.6298 22.4981 9.18825C22.4981 7.74669 21.9256 6.36414 20.9066 5.3445ZM19.8425 11.9782L12.0004 19.932L4.15348 11.9707C3.41502 11.2323 3.00016 10.2307 3.00016 9.18637C3.00016 8.14203 3.41502 7.14046 4.15348 6.402C4.89195 5.66354 5.89352 5.24867 6.93786 5.24867C7.9822 5.24867 8.98377 5.66354 9.72223 6.402L9.74098 6.42075L11.4894 8.04731C11.6282 8.17647 11.8108 8.24827 12.0004 8.24827C12.1899 8.24827 12.3725 8.17647 12.5113 8.04731L14.2597 6.42075L14.2785 6.402C15.0174 5.66403 16.0193 5.24985 17.0636 5.25055C18.108 5.25125 19.1093 5.66679 19.8472 6.40575C20.5852 7.14471 20.9994 8.14656 20.9987 9.1909C20.998 10.2352 20.5824 11.2365 19.8435 11.9745L19.8425 11.9782Z" fill="currentColor"/></svg>
                    </span>
                    <?php endif; ?>

                    <?php
                    // if ( $expire_timestamp && $settings['coupon_available_show_hide'] == 'yes' ) {

                    //     $current_timestamp = current_time( 'timestamp' ); // WordPress timezone aware

                    //     if ( $expire_timestamp > $current_timestamp ) {
                    //         $diff = $expire_timestamp - $current_timestamp;

                    //         $total_hours = floor( $diff / ( 60 * 60 ) );
                    //         $minutes     = floor( ( $diff % ( 60 * 60 ) ) / 60 );
                    //         $seconds     = $diff % 60;

                    //         echo '<span class="tp-coupon-meta-single-upper"><i class="tp tp-clock-regular"></i> End in: ';

                    //         // echo $total_hours . ' hour' . ( $total_hours != 1 ? 's' : '' ) . ' ';
                    //         // echo $minutes . ' minute' . ( $minutes != 1 ? 's' : '' ) . ' ';
                    //         // echo $seconds . ' second' . ( $seconds != 1 ? 's' : '' );

                    //         echo $total_hours . ':';
                    //         echo $minutes . ':';
                    //         echo $seconds;

                    //         echo '</span>';
                    //     } else {
                    //         echo '<span class="tp-coupon-meta-single-upper"> Expired </span>';
                    //     }
                    // }
                    ?>

                </div>

            </div>
            <?php endif; ?>

            <div class="tp-coupon-item position-relative" >

                <?php if( !empty( $image_src ) && $settings['image_show_hide'] == 'yes' || $settings['store_image_show_hide'] == 'yes' ){ ?>
                <div class="tp-coupon-item-img position-relative">

                    <?php if( $settings['show_top_meta'] == 'yes' && $settings['show_top_meta_position'] != 'yes' ) : ?>
                    <div class="tp-coupon-meta-inside-image position-absolute w-100">
                        <div class="tp-coupon-meta d-flex flex-wrap ">
                            <span class="tp-coupon-meta-left d-inline-flex">
                                <?php if( !empty( $exclusive ) && $settings['coupon_exclusive_show_hide'] == 'yes' && $settings['show_top_meta'] == 'yes' ) : ?>
                                <span class="tp-coupon-meta-single-upper tp-coupon-meta-exclusive"><?php echo esc_html__( 'Exclusive', 'tp-elements' ); ?></span>
                                <?php endif; ?>
                                <?php 
                                if( $settings['coupon_available_show_hide'] == 'yes' && $settings['show_top_meta'] == 'yes' ) {
                                    if ( $expire_timestamp ) {
                                        $current_timestamp = current_time( 'timestamp' );
                                        if ( $expire_timestamp > $current_timestamp ) {
                                            echo '<span class="tp-coupon-meta-single-upper tp-coupon-meta-exclusive"><i class="tp tp-check-1"></i> Available </span>';
                                        } else {
                                            echo '<span class="tp-coupon-meta-single-upper tp-coupon-meta-exclusive"> Expired </span>';
                                        }
                                    }
                                }              
                                ?>
                            </span>
                            <div class="tp-coupon-meta-right d-inline-flex">

                                <?php if( $settings['coupon_favourite_show_hide'] == 'yes' && $settings['show_top_meta'] == 'yes' ) : ?>
                                <span class="tp-coupon-meta-single-upper favorite-bookmark" data-coupon-id="<?php echo esc_attr( get_the_ID() ); ?>">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.9066 5.3445C19.8877 4.32811 18.5077 3.75655 17.0685 3.75479C15.6294 3.75303 14.248 4.32123 13.2266 5.33512L12.0004 6.47419L10.7732 5.33137C9.752 4.31307 8.36814 3.74212 6.92602 3.74415C5.48389 3.74617 4.10163 4.32099 3.08333 5.34216C2.06502 6.36332 1.49408 7.74718 1.4961 9.18931C1.49812 10.6314 2.07294 12.0137 3.09411 13.032L11.4707 21.5314C11.5405 21.6022 11.6236 21.6585 11.7154 21.6969C11.8071 21.7353 11.9056 21.7551 12.005 21.7551C12.1045 21.7551 12.203 21.7353 12.2947 21.6969C12.3864 21.6585 12.4696 21.6022 12.5394 21.5314L20.9066 13.032C21.9256 12.0124 22.4981 10.6298 22.4981 9.18825C22.4981 7.74669 21.9256 6.36414 20.9066 5.3445ZM19.8425 11.9782L12.0004 19.932L4.15348 11.9707C3.41502 11.2323 3.00016 10.2307 3.00016 9.18637C3.00016 8.14203 3.41502 7.14046 4.15348 6.402C4.89195 5.66354 5.89352 5.24867 6.93786 5.24867C7.9822 5.24867 8.98377 5.66354 9.72223 6.402L9.74098 6.42075L11.4894 8.04731C11.6282 8.17647 11.8108 8.24827 12.0004 8.24827C12.1899 8.24827 12.3725 8.17647 12.5113 8.04731L14.2597 6.42075L14.2785 6.402C15.0174 5.66403 16.0193 5.24985 17.0636 5.25055C18.108 5.25125 19.1093 5.66679 19.8472 6.40575C20.5852 7.14471 20.9994 8.14656 20.9987 9.1909C20.998 10.2352 20.5824 11.2365 19.8435 11.9745L19.8425 11.9782Z" fill="currentColor"/></svg>
                                </span>
                                <?php endif; ?>

                                <?php
                                // if ( $expire_timestamp && $settings['coupon_available_show_hide'] == 'yes' ) {

                                //     $current_timestamp = current_time( 'timestamp' ); // WordPress timezone aware

                                //     if ( $expire_timestamp > $current_timestamp ) {
                                //         $diff = $expire_timestamp - $current_timestamp;

                                //         $total_hours = floor( $diff / ( 60 * 60 ) );
                                //         $minutes     = floor( ( $diff % ( 60 * 60 ) ) / 60 );
                                //         $seconds     = $diff % 60;

                                //         echo '<span class="tp-coupon-meta-single-upper"><i class="tp tp-clock-regular"></i> End in: ';

                                //         // echo $total_hours . ' hour' . ( $total_hours != 1 ? 's' : '' ) . ' ';
                                //         // echo $minutes . ' minute' . ( $minutes != 1 ? 's' : '' ) . ' ';
                                //         // echo $seconds . ' second' . ( $seconds != 1 ? 's' : '' );

                                //         echo $total_hours . ':';
                                //         echo $minutes . ':';
                                //         echo $seconds;

                                //         echo '</span>';
                                //     } else {
                                //         echo '<span class="tp-coupon-meta-single-upper"> Expired </span>';
                                //     }
                                // }
                                ?>

                            </div>

                        </div>
                    </div>
                    <?php endif; ?>

                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr(get_post_meta($att, '_wp_attachment_image_alt', true )); ?>">
                    </a>
                    
                    <?php if( $settings['store_image_show_hide'] == 'yes' ){ ?>
                    <div class="tp-coupon-store-image-wrapp d-flex ">
                        <?php if( !empty( $store_image_url ) ){ ?>
                        <a href="<?php echo esc_url( $store_link ); ?>" class="tp-coupon-store-img">
                            <img src="<?php echo esc_url( $store_image_url ); ?>" alt="<?php echo esc_attr(get_post_meta($att, '_wp_attachment_image_alt', true )); ?>">
                        </a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <?php }?>

                <div class="tp-coupon-item-content-wrapper <?php echo esc_attr( $settings['button_position'] ); ?>">

                    <div class="tp-coupon-content-wrapp">

                        <?php if( $settings['show_after_title_meta'] == 'yes' && $settings['show_after_title_meta_position'] == 'yes' ) : ?>
                        <div class="tp-coupon-after-title-meta d-flex flex-wrap align-items-center ">

                            <?php if( !empty( $coupon_sale_price ) && $settings['regular_price_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-price "><?php echo esc_html__( '$', 'tp-elements' ) . $coupon_sale_price; ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $coupon_regular_price ) && $settings['regular_price_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-price <?php if( !empty( $coupon_sale_price )) : ?>tp-coupon-price-del <?php endif; ?>"><?php echo esc_html__( '$', 'tp-elements' ) . $coupon_regular_price; ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $discount_percentage ) && $settings['sale_parcentage_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-discount"><?php echo esc_html( ' - ' . $discount_percentage) . esc_html( '%', 'tp-elements' ); ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $coupon_cashback ) && $settings['cashback_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-cashback"> <?php echo esc_html($coupon_cashback); ?></span>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>

                        <?php if( $settings['coupon_title_show_hide'] == 'yes' ) : ?>
                        <<?php echo esc_attr( $settings['title_tag'] ); ?> class="tp-coupon-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $title_limit, '...' ); ?></a></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                        <?php endif; ?>

                        <?php if( $settings['show_after_title_meta'] == 'yes' && $settings['show_after_title_meta_position'] != 'yes' ) : ?>
                        <div class="tp-coupon-after-title-meta d-flex flex-wrap align-items-center ">

                            <?php if( !empty( $coupon_sale_price ) && $settings['regular_price_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-price "><?php echo esc_html__( '$', 'tp-elements' ) . $coupon_sale_price; ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $coupon_regular_price ) && $settings['regular_price_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-price <?php if( !empty( $coupon_sale_price )) : ?>tp-coupon-price-del <?php endif; ?>"><?php echo esc_html__( '$', 'tp-elements' ) . $coupon_regular_price; ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $discount_percentage ) && $settings['sale_parcentage_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-discount"><?php echo esc_html( ' - ' . $discount_percentage) . esc_html( '%', 'tp-elements' ); ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $coupon_cashback ) && $settings['cashback_show_hide'] == 'yes' && $settings['show_after_title_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-single tp-coupon-meta-cashback"> <?php echo esc_html($coupon_cashback); ?></span>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>

                        <?php if( $settings['before_button_meta'] == 'yes' ) : ?>
                        <div class="tp-coupon-before-button-meta d-flex flex-wrap">

                            <?php if( !empty( $verified ) && $settings['coupon_verified_show_hide'] == 'yes' && $settings['before_button_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-info-list-item"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.375C8.39303 2.375 6.82214 2.85152 5.486 3.74431C4.14985 4.6371 3.10844 5.90605 2.49348 7.3907C1.87852 8.87535 1.71762 10.509 2.03112 12.0851C2.34463 13.6612 3.11846 15.1089 4.25476 16.2452C5.39106 17.3815 6.8388 18.1554 8.4149 18.4689C9.99099 18.7824 11.6247 18.6215 13.1093 18.0065C14.594 17.3916 15.8629 16.3502 16.7557 15.014C17.6485 13.6779 18.125 12.107 18.125 10.5C18.1227 8.34581 17.266 6.28051 15.7427 4.75727C14.2195 3.23403 12.1542 2.37727 10 2.375ZM13.5672 9.06719L9.19219 13.4422C9.13415 13.5003 9.06522 13.5464 8.98934 13.5779C8.91347 13.6093 8.83214 13.6255 8.75 13.6255C8.66787 13.6255 8.58654 13.6093 8.51067 13.5779C8.43479 13.5464 8.36586 13.5003 8.30782 13.4422L6.43282 11.5672C6.31554 11.4499 6.24966 11.2909 6.24966 11.125C6.24966 10.9591 6.31554 10.8001 6.43282 10.6828C6.55009 10.5655 6.70915 10.4997 6.875 10.4997C7.04086 10.4997 7.19992 10.5655 7.31719 10.6828L8.75 12.1164L12.6828 8.18281C12.7409 8.12474 12.8098 8.07868 12.8857 8.04725C12.9616 8.01583 13.0429 7.99965 13.125 7.99965C13.2071 7.99965 13.2884 8.01583 13.3643 8.04725C13.4402 8.07868 13.5091 8.12474 13.5672 8.18281C13.6253 8.24088 13.6713 8.30982 13.7027 8.38569C13.7342 8.46156 13.7504 8.54288 13.7504 8.625C13.7504 8.70712 13.7342 8.78844 13.7027 8.86431C13.6713 8.94018 13.6253 9.00912 13.5672 9.06719Z" fill="currentColor"/></svg><?php echo esc_html__( 'Verified', 'tp-elements' ); ?></span>
                            <?php endif; ?>

                            <?php if( !empty( $coupon_affiliate ) && $settings['affiliate_site_show_hide'] == 'yes' && $settings['before_button_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-info-list-item"><?php echo '<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.375C8.39303 2.375 6.82214 2.85152 5.486 3.74431C4.14985 4.6371 3.10844 5.90605 2.49348 7.3907C1.87852 8.87535 1.71762 10.509 2.03112 12.0851C2.34463 13.6612 3.11846 15.1089 4.25476 16.2452C5.39106 17.3815 6.8388 18.1554 8.41489 18.4689C9.99099 18.7824 11.6247 18.6215 13.1093 18.0065C14.594 17.3916 15.8629 16.3502 16.7557 15.014C17.6485 13.6779 18.125 12.107 18.125 10.5C18.1227 8.34581 17.266 6.28051 15.7427 4.75727C14.2195 3.23403 12.1542 2.37727 10 2.375ZM16.875 10.5C16.8757 11.382 16.7059 12.2558 16.375 13.0734L12.8828 10.9258C12.7343 10.8342 12.5682 10.7748 12.3953 10.7516L10.6125 10.5109C10.3668 10.4789 10.1172 10.5201 9.89483 10.6293C9.67247 10.7386 9.48729 10.911 9.3625 11.125H8.68125L8.38438 10.5109C8.30231 10.34 8.18219 10.19 8.03324 10.0726C7.88428 9.95521 7.71043 9.87345 7.525 9.83359L6.9 9.69844L7.51094 8.625H8.81641C9.02766 8.62459 9.23538 8.57084 9.42032 8.46875L10.3773 7.94062C10.4614 7.89376 10.54 7.83768 10.6117 7.77344L12.7141 5.87188C12.9248 5.68298 13.0649 5.42788 13.1112 5.14865C13.1575 4.86942 13.1073 4.58276 12.9688 4.33594L12.9406 4.28516C14.117 4.84297 15.1111 5.72296 15.8075 6.82301C16.5039 7.92306 16.8741 9.19805 16.875 10.5ZM11.1961 3.72969L11.875 4.94531L9.77266 6.84687L8.81641 7.375H7.51094C7.29121 7.37468 7.07527 7.43228 6.8849 7.54201C6.69452 7.65173 6.53643 7.80971 6.42657 8L5.74453 9.18984L4.95157 7.07734L5.80625 5.05625C6.56277 4.47171 7.43304 4.05164 8.36132 3.82293C9.28959 3.59423 10.2554 3.56194 11.1969 3.72812L11.1961 3.72969ZM3.125 10.5C3.12396 9.47814 3.35194 8.46904 3.79219 7.54687L4.67813 9.91172C4.75196 10.1075 4.87376 10.2817 5.03237 10.4181C5.19098 10.5546 5.38132 10.6491 5.58594 10.693L7.26016 11.0531L7.55782 11.6719C7.66112 11.8823 7.82121 12.0597 8.02001 12.1839C8.2188 12.3082 8.44839 12.3744 8.68282 12.375H8.79844L8.2336 13.643C8.13407 13.8662 8.1022 14.1138 8.14191 14.355C8.18162 14.5962 8.29118 14.8204 8.45703 15L8.46797 15.0109L10 16.5891L9.84844 17.3703C8.05299 17.3285 6.34497 16.5867 5.08885 15.3031C3.83273 14.0196 3.12798 12.2959 3.125 10.5ZM11.1391 17.2797L11.2273 16.8258C11.2636 16.6329 11.2543 16.4343 11.2 16.2457C11.1457 16.0571 11.0481 15.8839 10.9148 15.7398C10.911 15.7364 10.9074 15.7327 10.9039 15.7289L9.375 14.1516L10.4453 11.75L12.2281 11.9906L15.8 14.1875C15.2825 15.0002 14.6003 15.6953 13.7975 16.2279C12.9946 16.7605 12.089 17.1188 11.1391 17.2797Z" fill="currentColor"/></svg>' . esc_html( parse_url( $coupon_affiliate, PHP_URL_HOST ) ); ?></span>
                            <?php endif; ?>

                            <?php if( ! empty( $current_used )  && $settings['coupon_usage_show_hide'] == 'yes' && $settings['before_button_meta'] == 'yes' ) : ?>
                            <span class="tp-coupon-info-list-item"><?php echo '<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.7492 8.6625C18.0316 8.60505 18.2854 8.45182 18.4678 8.22874C18.6501 8.00566 18.7498 7.72642 18.75 7.43828V5.5C18.75 5.16848 18.6183 4.85054 18.3839 4.61612C18.1495 4.3817 17.8315 4.25 17.5 4.25H2.5C2.16848 4.25 1.85054 4.3817 1.61612 4.61612C1.3817 4.85054 1.25 5.16848 1.25 5.5V7.43828C1.25016 7.72642 1.34986 8.00566 1.53223 8.22874C1.71459 8.45182 1.96843 8.60505 2.25078 8.6625C2.67298 8.75005 3.05209 8.98044 3.32427 9.31485C3.59644 9.64926 3.74505 10.0673 3.74505 10.4984C3.74505 10.9296 3.59644 11.3476 3.32427 11.682C3.05209 12.0164 2.67298 12.2468 2.25078 12.3344C1.9679 12.3919 1.71366 12.5456 1.53124 12.7693C1.34881 12.9931 1.24944 13.273 1.25 13.5617V15.5C1.25 15.8315 1.3817 16.1495 1.61612 16.3839C1.85054 16.6183 2.16848 16.75 2.5 16.75H17.5C17.8315 16.75 18.1495 16.6183 18.3839 16.3839C18.6183 16.1495 18.75 15.8315 18.75 15.5V13.5617C18.7498 13.2736 18.6501 12.9943 18.4678 12.7713C18.2854 12.5482 18.0316 12.3949 17.7492 12.3375C17.327 12.2499 16.9479 12.0196 16.6757 11.6851C16.4036 11.3507 16.255 10.9327 16.255 10.5016C16.255 10.0704 16.4036 9.65239 16.6757 9.31798C16.9479 8.98357 17.327 8.75318 17.7492 8.66562V8.6625ZM2.5 13.5625C3.20601 13.4187 3.84064 13.0353 4.29644 12.4773C4.75224 11.9193 5.00121 11.2209 5.00121 10.5004C5.00121 9.77988 4.75224 9.0815 4.29644 8.52349C3.84064 7.96547 3.20601 7.5821 2.5 7.43828V5.5H6.875V15.5H2.5V13.5625ZM17.5 13.5625V15.5H8.125V5.5H17.5V7.4375C16.794 7.58132 16.1594 7.96469 15.7036 8.52271C15.2478 9.08072 14.9988 9.7791 14.9988 10.4996C14.9988 11.2201 15.2478 11.9185 15.7036 12.4765C16.1594 13.0345 16.794 13.4179 17.5 13.5617V13.5625Z" fill="currentColor"/></svg>' . esc_html( $current_used ); ?></span>
                            <?php endif; ?>

                            <?php if( $settings['date_show_hide'] == 'yes' && $settings['before_button_meta'] == 'yes' ) : 
                            if( ! empty( $expire_timestamp )  ) : ?>
                            <span class="tp-coupon-info-list-item tp-coupon-date-single">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.375C8.39303 2.375 6.82214 2.85152 5.486 3.74431C4.14985 4.6371 3.10844 5.90605 2.49348 7.3907C1.87852 8.87535 1.71762 10.509 2.03112 12.0851C2.34463 13.6612 3.11846 15.1089 4.25476 16.2452C5.39106 17.3815 6.8388 18.1554 8.4149 18.4689C9.99099 18.7824 11.6247 18.6215 13.1093 18.0065C14.594 17.3916 15.8629 16.3502 16.7557 15.014C17.6485 13.6779 18.125 12.107 18.125 10.5C18.1227 8.34581 17.266 6.28051 15.7427 4.75727C14.2195 3.23403 12.1542 2.37727 10 2.375ZM10 17.375C8.64026 17.375 7.31105 16.9718 6.18046 16.2164C5.04987 15.4609 4.16868 14.3872 3.64833 13.1309C3.12798 11.8747 2.99183 10.4924 3.2571 9.15875C3.52238 7.82513 4.17716 6.60013 5.13864 5.63864C6.10013 4.67716 7.32514 4.02237 8.65876 3.7571C9.99238 3.49183 11.3747 3.62798 12.631 4.14833C13.8872 4.66868 14.9609 5.54987 15.7164 6.68045C16.4718 7.81104 16.875 9.14025 16.875 10.5C16.8729 12.3227 16.1479 14.0702 14.8591 15.3591C13.5702 16.6479 11.8227 17.3729 10 17.375ZM15 10.5C15 10.6658 14.9342 10.8247 14.8169 10.9419C14.6997 11.0592 14.5408 11.125 14.375 11.125H10C9.83424 11.125 9.67527 11.0592 9.55806 10.9419C9.44085 10.8247 9.375 10.6658 9.375 10.5V6.125C9.375 5.95924 9.44085 5.80027 9.55806 5.68306C9.67527 5.56585 9.83424 5.5 10 5.5C10.1658 5.5 10.3247 5.56585 10.4419 5.68306C10.5592 5.80027 10.625 5.95924 10.625 6.125V9.875H14.375C14.5408 9.875 14.6997 9.94085 14.8169 10.0581C14.9342 10.1753 15 10.3342 15 10.5Z" fill="currentColor"/></svg><?php echo date( 'd M, Y', $expire_timestamp ); ?>
                            </span>
                            <?php endif; endif; ?>

                        </div>
                        <?php endif; ?>

                        <?php if( $settings['coupon_text_show_hide'] == 'yes' ) : ?>
                        <div class="tp-coupon-desc">
                        <?php echo wp_kses_post( wp_trim_words( get_the_content(), $text_limit, '...' ) ); ?>
                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="tp-coupon-button-wrapp d-flex flex-wrap justify-content-between align-items-center gap-4 <?php echo esc_attr( $settings['button_vertical_align'] ); ?>">

                        <?php if( $settings['coupon_btn_show_hide'] == 'yes' ) : ?>
                        <div class="tp-coupon-button flex-grow-1">
                        <?php 
                        $href = '#o-' . get_the_ID();
                        $data_href = '';
                        $coupon_affiliate = get_post_meta(get_the_ID(), 'coupon_affiliate', true);

                        if (!empty($coupon_affiliate)) {
                            $href = add_query_arg(array()) . $href;
                            $data_href = add_query_arg(array('cout' => get_the_ID()), home_url('/'));

                        }

                        $current_coupon_type = get_post_meta(get_the_ID(), 'ctype', true);

                        $effective_coupon_type = !empty($coupon_type) ? $coupon_type : $current_coupon_type;

                        if ($effective_coupon_type == 1) {
                            $coupon_code = get_post_meta(get_the_ID(), 'coupon_code_change', true);
                            $link_open = $settings['coupon_btn_link_open'] == 'yes' ? 'target=_blank' : '';
                            $icon_position = $settings['coupon_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                            ?>
                            <a class="coupon-action-button header-alike <?php echo esc_attr( $icon_position ); ?>" href="<?php echo esc_attr($href); ?>" 
                            <?php if (!empty($data_href)) : ?> data-affiliate="<?php echo esc_url($data_href); ?>" target="_blank" <?php else : ?> target="" <?php endif; ?> rel="nofollow" >
                                <span class="code-text"><?php echo esc_html__('Reveal Coupon', 'tp-elements'); ?></span>
                                <span class="partial-code">&nbsp;<?php echo substr($coupon_code, -4, 4); ?></span>
                            </a>
                        <?php
                        } elseif ($effective_coupon_type == 2) {
                            $link_open = $settings['coupon_btn_link_open'] == 'yes' ? 'target=_blank' : '';
                            $icon_position = $settings['coupon_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                            ?>
                            <a class="coupon-action-button header-alike <?php echo esc_attr( $icon_position ); ?>" href="<?php echo esc_attr($href); ?>" 
                            <?php if (!empty($data_href)) : ?> data-affiliate="<?php echo esc_url($data_href); ?>" target="_blank" <?php else : ?> target="" <?php endif; ?> rel="nofollow"  >
                                <?php if( $settings['coupon_btn_icon_position'] == 'before' ) : ?>
                                    <?php if($settings['coupon_btn_icon']): ?>
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['coupon_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <span class="code-text-full"><?php echo esc_html( 'Print Code', 'tp-elements' ); ?></span>
                                <?php if( $settings['coupon_btn_icon_position'] == 'after' ) : ?>
                                    <?php if($settings['coupon_btn_icon']): ?>
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['coupon_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </a>
                        <?php
                        } elseif ($effective_coupon_type == 3) {
                            $link_open = $settings['coupon_btn_link_open'] == 'yes' ? 'target=_blank' : ''; 
                            $icon_position = $settings['coupon_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                            ?>
                            <a class="coupon-action-button header-alike <?php echo esc_attr( $icon_position ); ?>" href="<?php echo esc_attr($href); ?>" 
                            <?php if (!empty($data_href)) : ?> data-affiliate="<?php echo esc_url($data_href); ?>" target="_blank" <?php else : ?> target="" <?php endif; ?> rel="nofollow"  >
                                <?php if( $settings['coupon_btn_icon_position'] == 'before' ) : ?>
                                    <?php if($settings['coupon_btn_icon']): ?>
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['coupon_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <span class="code-text-full"><?php echo esc_html( 'Get Deal', 'tp-elements' ); ?></span>
                                <?php if( $settings['coupon_btn_icon_position'] == 'after' ) : ?>
                                    <?php if($settings['coupon_btn_icon']): ?>
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['coupon_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </a>
                        <?php
                        }
                        ?>

                        </div>
                        <?php endif; ?>

                        <?php if( $settings['coupon_share_show_hide'] != 'yes' ) : ?>
                        <span class="tp-coupon-meta-after-button-item toggle-coupon-share-<?php echo esc_attr( $unique ); ?> toggle-coupon-share" data-target="share-<?php echo esc_attr( get_the_ID() ); ?>" id="share-btn-<?php echo esc_attr( get_the_ID() ); ?>">
                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.8994 0.876953C10.9237 0.881789 10.9464 0.894617 10.9639 0.912109L17.2139 7.16211C17.2368 7.18547 17.25 7.21723 17.25 7.25C17.2499 7.283 17.2362 7.31452 17.2129 7.33789L10.9639 13.5879C10.9464 13.6054 10.9237 13.6172 10.8994 13.6221C10.8752 13.6269 10.85 13.6247 10.8271 13.6152C10.8045 13.6059 10.7852 13.5897 10.7715 13.5693C10.7647 13.5591 10.7584 13.5478 10.7549 13.5361L10.75 13.499V9.86133L10.2217 9.8916C5.56549 10.1574 2.39402 13.168 1.50781 14.1113L1.50684 14.1123C1.44404 14.1793 1.36157 14.2246 1.27148 14.2422C1.18124 14.2598 1.08735 14.2485 1.00391 14.21C0.998581 14.2075 0.993487 14.2038 0.988281 14.2012L2.00488 13.2676C2.84557 12.4956 3.77264 11.823 4.76758 11.2637L4.76855 11.2646C6.71847 10.1736 8.77143 9.625 10.875 9.625C10.908 9.62501 10.9395 9.6379 10.9629 9.66113C10.9863 9.68457 11 9.71685 11 9.75V13.1982L16.9482 7.25L11 1.30176V4.75C10.9999 4.78305 10.9863 4.81452 10.9629 4.83789C10.9395 4.86125 10.9081 4.87499 10.875 4.875C8.96162 4.875 6.79867 5.73739 4.98633 7.15918L4.62891 7.45117C2.87054 8.9429 1.66325 10.802 1.18164 12.7812L0.859375 14.1006C0.83937 14.0778 0.820664 14.0531 0.805664 14.0264C0.760829 13.9462 0.742401 13.854 0.75293 13.7627C1.02613 11.3871 2.33139 9.0727 4.4668 7.26074C6.24284 5.75446 8.38656 4.81355 10.293 4.65039L10.75 4.61133V1C10.75 0.975276 10.7577 0.951214 10.7715 0.930664C10.7852 0.910194 10.8044 0.894209 10.8271 0.884766C10.85 0.875326 10.8752 0.872138 10.8994 0.876953Z" stroke="currentColor"/></svg> <?php echo esc_html__('Share & Earn', 'tp-elements'); ?>
                        </span>
                        <?php endif; ?>

                    </div>


                    <?php if( $settings['after_button_meta'] == 'yes' ) : ?>
                    <div class="tp-coupon-after-button-meta d-flex flex-wrap ">
                        
                        <div class="tp-coupon-meta-left d-inline-flex">
                            <?php if( $settings['after_button_meta'] == 'yes' && $settings['coupon_feedback_show_hide'] == 'yes' ) : 

                            $positive_feedback = get_post_meta( $post_id, 'positive', true );
                            $negative_feedback = get_post_meta( $post_id, 'negative', true );

                            $coupon_ids = tp_coupon_get_feedback_cookie();

                            if (in_array($post_id, $coupon_ids)) {
                                echo '<a href="javascript:;" class="disabled tp-coupon-meta-after-button-item"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.2812 6.75938C18.1053 6.55994 17.8888 6.40023 17.6464 6.29086C17.4039 6.18148 17.141 6.12495 16.875 6.125H12.5V4.875C12.5 4.0462 12.1708 3.25134 11.5847 2.66529C10.9987 2.07924 10.2038 1.75 9.375 1.75C9.25889 1.74992 9.14505 1.78218 9.04625 1.84317C8.94744 1.90417 8.86758 1.99148 8.81562 2.09531L5.86406 8H2.5C2.16848 8 1.85054 8.1317 1.61612 8.36612C1.3817 8.60054 1.25 8.91848 1.25 9.25V16.125C1.25 16.4565 1.3817 16.7745 1.61612 17.0089C1.85054 17.2433 2.16848 17.375 2.5 17.375H15.9375C16.3943 17.3752 16.8354 17.2085 17.1781 16.9065C17.5208 16.6044 17.7413 16.1876 17.7984 15.7344L18.7359 8.23438C18.7692 7.97033 18.7458 7.70224 18.6674 7.44792C18.589 7.1936 18.4574 6.95888 18.2812 6.75938ZM2.5 9.25H5.625V16.125H2.5V9.25ZM17.4953 8.07812L16.5578 15.5781C16.5388 15.7292 16.4653 15.8681 16.351 15.9688C16.2368 16.0695 16.0898 16.1251 15.9375 16.125H6.875V8.77266L9.74297 3.03594C10.168 3.12101 10.5505 3.35075 10.8253 3.68605C11.1 4.02135 11.2501 4.4415 11.25 4.875V6.75C11.25 6.91576 11.3158 7.07473 11.4331 7.19194C11.5503 7.30915 11.7092 7.375 11.875 7.375H16.875C16.9637 7.37497 17.0514 7.39382 17.1322 7.43028C17.2131 7.46675 17.2852 7.52001 17.3439 7.58652C17.4026 7.65303 17.4464 7.73126 17.4725 7.81602C17.4986 7.90078 17.5064 7.99013 17.4953 8.07812Z" fill="currentColor"/></svg> ' . $positive_feedback . '</a>';
                                echo '<a href="javascript:;" class="disabled tp-coupon-meta-after-button-item"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.7359 12.7656L17.7984 5.26563C17.7413 4.81241 17.5208 4.39562 17.1781 4.09354C16.8354 3.79145 16.3943 3.62484 15.9375 3.625H2.5C2.16848 3.625 1.85054 3.7567 1.61612 3.99112C1.3817 4.22554 1.25 4.54348 1.25 4.875V11.75C1.25 12.0815 1.3817 12.3995 1.61612 12.6339C1.85054 12.8683 2.16848 13 2.5 13H5.86406L8.81563 18.9047C8.86759 19.0085 8.94744 19.0958 9.04625 19.1568C9.14505 19.2178 9.25889 19.2501 9.375 19.25C10.2038 19.25 10.9987 18.9208 11.5847 18.3347C12.1708 17.7487 12.5 16.9538 12.5 16.125V14.875H16.875C17.1411 14.8751 17.4041 14.8186 17.6467 14.7091C17.8892 14.5997 18.1057 14.44 18.2817 14.2404C18.4577 14.0409 18.5892 13.8062 18.6676 13.5519C18.7459 13.2976 18.7692 13.0296 18.7359 12.7656ZM5.625 11.75H2.5V4.875H5.625V11.75ZM17.3438 13.4133C17.2855 13.4803 17.2135 13.5339 17.1325 13.5704C17.0516 13.607 16.9638 13.6256 16.875 13.625H11.875C11.7092 13.625 11.5503 13.6908 11.4331 13.8081C11.3158 13.9253 11.25 14.0842 11.25 14.25V16.125C11.2501 16.5585 11.1 16.9787 10.8253 17.314C10.5505 17.6493 10.168 17.879 9.74297 17.9641L6.875 12.2273V4.875H15.9375C16.0898 4.87495 16.2368 4.93048 16.351 5.03118C16.4653 5.13187 16.5388 5.2708 16.5578 5.42188L17.4953 12.9219C17.507 13.0099 17.4995 13.0994 17.4734 13.1842C17.4472 13.269 17.403 13.3472 17.3438 13.4133Z" fill="currentColor"/></svg> ' . $negative_feedback . '</a>';
                            } else {
                                echo '<a href="javascript:;" class="feedback-record-action tp-coupon-meta-after-button-item" data-value="+" data-coupon_id="' . esc_attr($post_id) . '"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.2812 6.75938C18.1053 6.55994 17.8888 6.40023 17.6464 6.29086C17.4039 6.18148 17.141 6.12495 16.875 6.125H12.5V4.875C12.5 4.0462 12.1708 3.25134 11.5847 2.66529C10.9987 2.07924 10.2038 1.75 9.375 1.75C9.25889 1.74992 9.14505 1.78218 9.04625 1.84317C8.94744 1.90417 8.86758 1.99148 8.81562 2.09531L5.86406 8H2.5C2.16848 8 1.85054 8.1317 1.61612 8.36612C1.3817 8.60054 1.25 8.91848 1.25 9.25V16.125C1.25 16.4565 1.3817 16.7745 1.61612 17.0089C1.85054 17.2433 2.16848 17.375 2.5 17.375H15.9375C16.3943 17.3752 16.8354 17.2085 17.1781 16.9065C17.5208 16.6044 17.7413 16.1876 17.7984 15.7344L18.7359 8.23438C18.7692 7.97033 18.7458 7.70224 18.6674 7.44792C18.589 7.1936 18.4574 6.95888 18.2812 6.75938ZM2.5 9.25H5.625V16.125H2.5V9.25ZM17.4953 8.07812L16.5578 15.5781C16.5388 15.7292 16.4653 15.8681 16.351 15.9688C16.2368 16.0695 16.0898 16.1251 15.9375 16.125H6.875V8.77266L9.74297 3.03594C10.168 3.12101 10.5505 3.35075 10.8253 3.68605C11.1 4.02135 11.2501 4.4415 11.25 4.875V6.75C11.25 6.91576 11.3158 7.07473 11.4331 7.19194C11.5503 7.30915 11.7092 7.375 11.875 7.375H16.875C16.9637 7.37497 17.0514 7.39382 17.1322 7.43028C17.2131 7.46675 17.2852 7.52001 17.3439 7.58652C17.4026 7.65303 17.4464 7.73126 17.4725 7.81602C17.4986 7.90078 17.5064 7.99013 17.4953 8.07812Z" fill="currentColor"/></svg> ' . $positive_feedback . '</a>';
                                echo '<a href="javascript:;" class="feedback-record-action tp-coupon-meta-after-button-item" data-value="-" data-coupon_id="' . esc_attr($post_id) . '"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.7359 12.7656L17.7984 5.26563C17.7413 4.81241 17.5208 4.39562 17.1781 4.09354C16.8354 3.79145 16.3943 3.62484 15.9375 3.625H2.5C2.16848 3.625 1.85054 3.7567 1.61612 3.99112C1.3817 4.22554 1.25 4.54348 1.25 4.875V11.75C1.25 12.0815 1.3817 12.3995 1.61612 12.6339C1.85054 12.8683 2.16848 13 2.5 13H5.86406L8.81563 18.9047C8.86759 19.0085 8.94744 19.0958 9.04625 19.1568C9.14505 19.2178 9.25889 19.2501 9.375 19.25C10.2038 19.25 10.9987 18.9208 11.5847 18.3347C12.1708 17.7487 12.5 16.9538 12.5 16.125V14.875H16.875C17.1411 14.8751 17.4041 14.8186 17.6467 14.7091C17.8892 14.5997 18.1057 14.44 18.2817 14.2404C18.4577 14.0409 18.5892 13.8062 18.6676 13.5519C18.7459 13.2976 18.7692 13.0296 18.7359 12.7656ZM5.625 11.75H2.5V4.875H5.625V11.75ZM17.3438 13.4133C17.2855 13.4803 17.2135 13.5339 17.1325 13.5704C17.0516 13.607 16.9638 13.6256 16.875 13.625H11.875C11.7092 13.625 11.5503 13.6908 11.4331 13.8081C11.3158 13.9253 11.25 14.0842 11.25 14.25V16.125C11.2501 16.5585 11.1 16.9787 10.8253 17.314C10.5505 17.6493 10.168 17.879 9.74297 17.9641L6.875 12.2273V4.875H15.9375C16.0898 4.87495 16.2368 4.93048 16.351 5.03118C16.4653 5.13187 16.5388 5.2708 16.5578 5.42188L17.4953 12.9219C17.507 13.0099 17.4995 13.0994 17.4734 13.1842C17.4472 13.269 17.403 13.3472 17.3438 13.4133Z" fill="currentColor"/></svg> ' . $negative_feedback . '</a>';
                            }

                            ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="tp-coupon-meta-right d-inline-flex">

                            <?php if( $settings['coupon_share_show_hide'] == 'yes' ) : ?>
                            <span class="tp-coupon-meta-after-button-item toggle-coupon-share-<?php echo esc_attr( $unique ); ?> toggle-coupon-share" data-target="share-<?php echo esc_attr( get_the_ID() ); ?>" id="share-btn-<?php echo esc_attr( get_the_ID() ); ?>">
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.8994 0.876953C10.9237 0.881789 10.9464 0.894617 10.9639 0.912109L17.2139 7.16211C17.2368 7.18547 17.25 7.21723 17.25 7.25C17.2499 7.283 17.2362 7.31452 17.2129 7.33789L10.9639 13.5879C10.9464 13.6054 10.9237 13.6172 10.8994 13.6221C10.8752 13.6269 10.85 13.6247 10.8271 13.6152C10.8045 13.6059 10.7852 13.5897 10.7715 13.5693C10.7647 13.5591 10.7584 13.5478 10.7549 13.5361L10.75 13.499V9.86133L10.2217 9.8916C5.56549 10.1574 2.39402 13.168 1.50781 14.1113L1.50684 14.1123C1.44404 14.1793 1.36157 14.2246 1.27148 14.2422C1.18124 14.2598 1.08735 14.2485 1.00391 14.21C0.998581 14.2075 0.993487 14.2038 0.988281 14.2012L2.00488 13.2676C2.84557 12.4956 3.77264 11.823 4.76758 11.2637L4.76855 11.2646C6.71847 10.1736 8.77143 9.625 10.875 9.625C10.908 9.62501 10.9395 9.6379 10.9629 9.66113C10.9863 9.68457 11 9.71685 11 9.75V13.1982L16.9482 7.25L11 1.30176V4.75C10.9999 4.78305 10.9863 4.81452 10.9629 4.83789C10.9395 4.86125 10.9081 4.87499 10.875 4.875C8.96162 4.875 6.79867 5.73739 4.98633 7.15918L4.62891 7.45117C2.87054 8.9429 1.66325 10.802 1.18164 12.7812L0.859375 14.1006C0.83937 14.0778 0.820664 14.0531 0.805664 14.0264C0.760829 13.9462 0.742401 13.854 0.75293 13.7627C1.02613 11.3871 2.33139 9.0727 4.4668 7.26074C6.24284 5.75446 8.38656 4.81355 10.293 4.65039L10.75 4.61133V1C10.75 0.975276 10.7577 0.951214 10.7715 0.930664C10.7852 0.910194 10.8044 0.894209 10.8271 0.884766C10.85 0.875326 10.8752 0.872138 10.8994 0.876953Z" stroke="currentColor"/></svg>
                            </span>
                            <?php endif; ?>

                            <?php if( $settings['after_button_meta'] == 'yes' && $settings['coupon_comments_show_hide'] == 'yes' ) : ?>
                            <a href="<?php echo get_comments_link(); ?>" class="tp-coupon-meta-after-button-item"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.125 9.25C13.125 9.41576 13.0592 9.57473 12.9419 9.69194C12.8247 9.80915 12.6658 9.875 12.5 9.875H7.5C7.33424 9.875 7.17527 9.80915 7.05806 9.69194C6.94085 9.57473 6.875 9.41576 6.875 9.25C6.875 9.08424 6.94085 8.92527 7.05806 8.80806C7.17527 8.69085 7.33424 8.625 7.5 8.625H12.5C12.6658 8.625 12.8247 8.69085 12.9419 8.80806C13.0592 8.92527 13.125 9.08424 13.125 9.25ZM12.5 11.125H7.5C7.33424 11.125 7.17527 11.1908 7.05806 11.3081C6.94085 11.4253 6.875 11.5842 6.875 11.75C6.875 11.9158 6.94085 12.0747 7.05806 12.1919C7.17527 12.3092 7.33424 12.375 7.5 12.375H12.5C12.6658 12.375 12.8247 12.3092 12.9419 12.1919C13.0592 12.0747 13.125 11.9158 13.125 11.75C13.125 11.5842 13.0592 11.4253 12.9419 11.3081C12.8247 11.1908 12.6658 11.125 12.5 11.125ZM18.125 10.1875C18.1227 12.2588 17.2989 14.2446 15.8343 15.7093C14.3696 17.1739 12.3838 17.9977 10.3125 18H3.72422C3.39966 17.9996 3.08852 17.8705 2.85902 17.641C2.62953 17.4115 2.50041 17.1003 2.5 16.7758V10.1875C2.5 8.1155 3.3231 6.12836 4.78823 4.66323C6.25336 3.1981 8.2405 2.375 10.3125 2.375C12.3845 2.375 14.3716 3.1981 15.8368 4.66323C17.3019 6.12836 18.125 8.1155 18.125 10.1875ZM16.875 10.1875C16.875 8.44702 16.1836 6.77782 14.9529 5.54711C13.7222 4.3164 12.053 3.625 10.3125 3.625C8.57202 3.625 6.90282 4.3164 5.67211 5.54711C4.4414 6.77782 3.75 8.44702 3.75 10.1875V16.75H10.3125C12.0524 16.7481 13.7205 16.0561 14.9508 14.8258C16.1811 13.5955 16.8731 11.9274 16.875 10.1875Z" fill="currentColor"/></svg> <?php echo get_comments_number() ?>
                            </a>
                            <?php endif; ?>

                        </div>

                    </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <!-- share start -->
        <div class="share-coupon share-<?php echo esc_attr( get_the_ID() ); ?> ">
            <div class="tp-post-share-absolute">
            <?php    
            if( !empty( $coupon_id ) ){
                $share_post_id = $coupon_id;
            } else {
                $share_post_id = get_the_ID();
            }
            ?>
            <div class="post-share">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( rawurlencode( get_permalink( $share_post_id ) ) ); ?>" class="share facebook" target="_blank" title="<?php esc_attr_e( 'Share on Facebook', 'tp-elements' ); ?>"><i class="fa fa-facebook fa-fw"></i></a>
                <a href="https://twitter.com/intent/tweet?source=<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>&amp;text=<?php echo esc_url( rawurlencode( get_permalink( $share_post_id ) ) ); ?>" class="share twitter" target="_blank" title="<?php esc_attr_e( 'Share on Twitter', 'tp-elements' ); ?>"><i class="fa fa-twitter fa-fw"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( rawurlencode( get_permalink( $share_post_id ) ) ); ?>&amp;title=<?php echo esc_url( rawurlencode( get_the_title( $share_post_id ) ) ); ?>&amp;source=<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="share linkedin" target="_blank" title="<?php esc_attr_e( 'Share on LinkedIn', 'tp-elements' ); ?>"><i class="fa fa-linkedin fa-fw"></i></a>
                <a href="https://www.tumblr.com/share/link?url=<?php echo esc_url( rawurlencode( get_permalink( $share_post_id ) ) ); ?>&amp;name=<?php echo esc_url( rawurlencode( get_the_title( $share_post_id ) ) ); ?>" class="share tumblr" target="_blank" title="<?php esc_attr_e( 'Share on Tumblr', 'tp-elements' ); ?>"><i class="fa fa-tumblr fa-fw"></i></a>
                <a href="https://t.me/share/url?url=<?php echo esc_url( rawurlencode( get_permalink( $share_post_id ) ) ); ?>&amp;text=<?php echo esc_url( rawurlencode( get_the_title( $share_post_id ) ) ); ?>" class="share telegram" target="_blank" title="<?php esc_attr_e( 'Share on Telegram', 'tp-elements' ); ?>"><i class="fa fa-telegram fa-fw"></i></a>
                <a href="https://api.whatsapp.com/send?text=<?php echo esc_url( rawurlencode( get_permalink( $share_post_id ) ) ); ?>" class="share whatsapp" target="_blank" title="<?php esc_attr_e( 'Share on WhatsApp', 'tp-elements' ); ?>"><i class="fa fa-whatsapp fa-fw"></i></a>
            </div>

            <a href="javascript:;" class="toggle-coupon-share-<?php echo esc_attr( $unique ); ?> toggle-coupon-share" data-target="share-<?php echo esc_attr( get_the_ID() ) ?>"><span class="icon-close">x</span></a>
            </div>
        </div>
        <!-- share end -->

    </div>
   
</div>