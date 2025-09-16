<div class="col-xl-<?php echo esc_attr( $col_xl ); ?> col-lg-<?php echo esc_attr( $col_lg ); ?> col-md-<?php echo esc_attr( $col_md ); ?> col-sm-<?php echo esc_attr( $col_sm ); ?> col-<?php echo esc_attr( $col_xs ); ?>">

    <div class="pixelaxis-addon-services <?php echo esc_attr( $settings['image_or_icon_vertical_align'] ); ?> <?php echo esc_attr( $settings['image_or_icon_position'] ); ?> services-<?php echo esc_attr( $settings['services_style'] ); ?> services-<?php echo esc_attr( $settings['service_grid_source'] ); ?>">
        <div class="services-part">
            <?php if( !empty( $image_url ) ){?>
            <div class="services-icon">
                <img src="<?php echo esc_url( $image_url ); ?>" alt="image"/>
            </div>
            <?php }?> 	
            <div class="services-text">
                <?php if(($settings['services_meta_show_hide'] == 'yes') ){ ?>
                <ul class="service-meta">
                    <?php if( ($settings['services_trainer_show_hide'] == 'yes') && !empty( $service_trainer_name ) ){ ?>
                    <li><span class="meta_trainer"><i class="fa fa-user-o"></i><?php echo esc_html( $service_trainer_name ); ?></span></li>
                    <?php } ?>
                    <?php if( ($settings['services_cat_show_hide'] == 'yes') && !empty( $first_category_name ) ){ ?>
                    <li><span class="meta_cat"><i class="fa fa-bookmark-o"></i><?php echo esc_html( $first_category_name ); ?></span></li>
                    <?php } ?>
                    <?php if(($settings['services_schedule_show_hide'] == 'yes')  && !empty( $service_schedule_time ) ){ ?>
                    <li><span class="meta_time"><i class="fa fa-clock-o"></i><?php echo esc_html( $service_schedule_time ); ?></span></li>
                    <?php } ?>
                    <?php if(($settings['services_fee_show_hide'] == 'yes')  && !empty( $service_training_fee ) ){ ?>
                    <li><span class="meta_fee"><i class="fa fa-credit-card"></i><?php echo esc_html( $service_training_fee ); ?></span></li>
                    <?php } ?>
                </ul>
                <?php } ?>
                <div class="services-title">					    							    			
                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $title_limit, '...' ); ?></a></h2>				    		
                </div>
                <?php if(($settings['services_text_show_hide'] == 'yes') ){ ?>
                <p class="services-desc"><?php echo wp_trim_words( get_the_excerpt(), $text_limit, '...' ); ?></p>
                <?php } ?>
                <?php if(!empty($settings['services_btn_text'])){ ?>
                <div class="services-btn-part mt-20">
                    <?php 
                        $link_open = $settings['services_btn_link_open'] == 'yes' ? 'target=_blank' : ''; 		    		 
                        $icon_position = $settings['services_btn_icon_position'] == 'before' ? 'icon-before' : 'icon-after';
                    ?>		    		
                    <a class="services-btn <?php echo esc_html($icon_position); ?>" href="<?php the_permalink(); ?>" <?php echo wp_kses_post($link_open); ?>>
						<?php if( $settings['services_btn_icon_position'] == 'before' ) : ?>
							<?php if($settings['services_btn_icon']): ?>
							<?php \Elementor\Icons_Manager::render_icon( $settings['services_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php endif; ?>
						<?php endif; ?>
	    				<span class="btn_text">
	    					<?php echo esc_html($settings['services_btn_text']);?>    						
	    				</span>	
						<?php if( $settings['services_btn_icon_position'] == 'after' ) : ?> 				
							<?php if($settings['services_btn_icon']): ?>
							<?php \Elementor\Icons_Manager::render_icon( $settings['services_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php endif; ?>
						<?php endif; ?>
	    		 	</a>	 
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>