<?php 

add_action('wp_footer', 'subscription_modal_pop');
function subscription_modal_pop() {
	global $subscription_option;
	$subscription_enabled = !empty($subscription_option['enable_subscription_modal']) ? $subscription_option['enable_subscription_modal'] :  '';
	if( !$subscription_enabled == 1 ) return;
	$subscription_title = $subscription_option['subscription_title'];
	$subscription_subtitle = $subscription_option['subscription_subtitle'];
	$subscription_shortcode = $subscription_option['subscription_shortcode'];
	$subscription_notice = $subscription_option['subscription_info_notice'];
	$subscription_bg = $subscription_option['subscription_bg']['id'];
	$banner = wp_get_attachment_image_src($subscription_bg, 'large')[0];
	
	
	if( empty($subscription_shortcode) && $banner == '' ) return;
    ?>
	<div class="modal fade modal-lg " id="tpSubscriptionModal" tabindex="-1" aria-labelledby="tpSubscriptionModalLabel" aria-hidden="true" data-bs-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
			<div class="modal-body position-relative p-0">
	          <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="<?php echo esc_html('Close'); ?>"></button>
			    <div class="row align-items-center rounded">
			    	<?php 
			    		if( $banner ){
			    			?>
					      <div class="col d-none d-md-block p-0 subscription-image-col">
					      	<img src="<?php echo esc_url($banner);?>" alt="<?php echo esc_html('Subscription Modal'); ?>" class="subs-image">
					      </div>			    				
			    			<?php
			    		}
			    		if( $subscription_shortcode ){
			    			?>
					      <div class="col subscription-box-col">
					      	<div class="subscription-box py-3 ps-3 pe-4">
						      	<h3 class="modal-title mb-3" id="tpSubscriptionModalLabel"><?php echo esc_html($subscription_title); ?></h3>
								<p class="subscription-subtitle mb-2"><?php echo esc_html($subscription_subtitle); ?></p>
						      	<?php echo do_shortcode($subscription_shortcode); ?>
						      	<p class="info-notice mt-2 fw-bold"><?php echo esc_html($subscription_notice); ?></p>
					      	</div>
					      </div>			    				
			    			<?php
			    		}
			    	?>
			    </div>
			</div>
	    </div>
	  </div>
	</div>
    <?php
}