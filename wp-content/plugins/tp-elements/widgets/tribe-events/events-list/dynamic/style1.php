<div class="pixelaxis-addon-events-list <?php echo esc_attr( $settings['image_or_icon_position'] ); ?> <?php echo esc_attr($classes); ?>">
    <div class="events-part events-list-part ">
        <div class="event-date order-1">
            <h4 class="event-day"><?php echo esc_html( $day_of_start_date ); ?></h4>
            <span class="event-date-rest"><?php echo esc_html( $month_year_of_start_date ); ?></span>
        </div>
        <?php if( !empty( $image_src ) ){ ?>
        <div class="events-icon order-<?php echo esc_attr( $settings['image_or_icon_position'] ); ?>">
            <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr(get_post_meta($att, '_wp_attachment_image_alt', true)); ?>"/>
        </div>
        <?php }?> 	
        <div class="events-text order-3">

            <div class="events-title">					    							    			
                <h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $title_limit, '...' ); ?></a></h2>				    		
            </div>

            <?php if(($settings['event_meta_show_hide'] == 'yes') ){ ?>
            <div class="events-meta">
                <?php if( ($settings['event_start_date_schedule'] == 'yes') ){ ?>
                <span class="meta_date"><i class="tp tp-calendar-days"></i><?php echo esc_html( $start_date ); ?></span>
                <?php } ?>
                <?php if( ($settings['event_start_time_schedule'] == 'yes') ){ ?>
                <span class="meta_date"><i class="tp tp-clock-regular"></i><?php echo esc_html( $start_time ); ?></span>
                <?php } ?>
                <?php if(($settings['event_cat_show_hide'] == 'yes') && !empty( $first_category_name )){ ?>
                <span class="meta_cat"><?php echo esc_html( $first_category_name ); ?></span>
                <?php } ?>
                <?php if( ($settings['event_location_show_hide'] == 'yes') ){ ?>
                <span class="meta_location"><i class="tp tp-location-dot"></i><?php echo esc_html( $location ); ?></span>
                <?php } ?>
                <?php if( ($settings['event_fee_show_hide'] == 'yes') ){ ?>
                <span class="meta_date"><?php echo esc_html( $_EventCurrencySymbol ); ?><?php echo esc_html( $_EventCost ); ?></span>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if(($settings['event_text_show_hide'] == 'yes') ){ ?>
            <p class="events-desc"><?php echo wp_trim_words( get_the_excerpt(), $text_limit, '...' ); ?></p>
            <?php } ?>

        </div>
        <?php if(($settings['event_btn_show_hide'] == 'yes')){ ?>
        <div class="events-btn-part order-4">
            <?php 
                $link_open = $settings['event_btn_link_open'] == 'yes' ? 'target=_blank' : ''; 		    		 
                $icon_position = $settings['event_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
            ?>		    		
            <a class="events-btn <?php echo esc_html($icon_position); ?>" href="<?php the_permalink(); ?>" <?php echo wp_kses_post($link_open); ?>>
                <?php if( $settings['event_btn_icon_position'] == 'before' ) : ?>
                    <?php if($settings['event_btn_icon']): ?>
                    <?php \Elementor\Icons_Manager::render_icon( $settings['event_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if( !empty( $settings['event_btn_text'] ) ): ?>
                <span class="btn_text">
                    <?php echo esc_html($settings['event_btn_text']);?>    						
                </span>	
                <?php endif; ?>
                <?php if( $settings['event_btn_icon_position'] == 'after' ) : ?> 				
                    <?php if($settings['event_btn_icon']): ?>
                    <?php \Elementor\Icons_Manager::render_icon( $settings['event_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </a>	 
        </div>
        <?php } ?>
    </div>
</div>