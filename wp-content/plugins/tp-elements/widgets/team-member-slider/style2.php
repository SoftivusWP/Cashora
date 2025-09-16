<?php 
$cat = $settings['team_category'];

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if(empty($cat)){
	$best_wp = new wp_Query(array(
		'post_type'      => 'teams',
		'posts_per_page' => $settings['per_page'],
		'paged'          => $paged					
	));	  
}   
else{
	$best_wp = new wp_Query(array(
		'post_type'      => 'teams',
		'posts_per_page' => $settings['per_page'],
		'paged'          => $paged,
		'tax_query'      => array(
	        array(
				'taxonomy' => 'team-category',
				'field'    => 'slug', //can be set to ID
				'terms'    => $cat //if field is ID you can reference by cat/term number
	        ),
	    )
	));	  
}

while($best_wp->have_posts()): $best_wp->the_post();

    $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';			
    									   
	//retrive social icon values			
	$facebook    = get_post_meta( get_the_ID(), 'facebook', true );
	$twitter     = get_post_meta( get_the_ID(), 'twitter', true );
	$google_plus = get_post_meta( get_the_ID(), 'google_plus', true );
	$instagram   = get_post_meta( get_the_ID(), 'instagram', true );
	$linkedin    = get_post_meta( get_the_ID(), 'linkedin', true );
	$show_phone  = get_post_meta( get_the_ID(), 'phone', true );
	$show_email  = get_post_meta( get_the_ID(), 'email', true );
	
	$fb   ='';
	$tw   ='';
	$gp   ='';
	$ins  ='';
	$ldin ='';

	if($facebook!=''){
		$fb='<a href="'.$facebook.'" class="social-icon"><i class="fab fa-facebook-f"></i></a> ';
	}
	if($twitter!=''){
		$tw='<a href="'.$twitter.'" class="social-icon"><i class="fab fa-twitter"></i></a>';
	}
	if($google_plus!=''){
		$gp='<a href="'.$google_plus.'" class="social-icon"><i class="fab fa-google-plus-g"></i></a> ';
	}
	if($instagram!=''){
		$ins='<a href="'.$instagram.'" class="social-icon"><i class="fab fa-instagram"></i></a>';
	}
	if($linkedin!=''){
		$ldin='<a href="'.$linkedin.'" class="social-icon"><i class="fab fa-linkedin-in"></i></a>';
	}
?>
<div class="team-item swiper-slide">
	<div class="team-inner-wrap">
		<div class="image-wrap">			
				<a href="<?php the_permalink();?>">
					<?php the_post_thumbnail(); ?>
				</a>
					   
		</div>	
		<div class="team-content">	
			<div class="header">							            
				<h5 class="team-name"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
				<div class="team-title nolink"><?php echo esc_html( $designation );?></div>
			</div>
			<?php if( $fb || $gp || $tw || $ins || $ldin): ?>
			<div class="social-icons">
				<?php echo wp_kses_post($fb);
					echo wp_kses_post($gp);
					echo wp_kses_post($tw);
					echo wp_kses_post($ins);
					echo wp_kses_post($ldin);
				?>
			</div>
		<?php endif; ?>   
	</div>				    
	</div>
</div>

<?php	
endwhile;
wp_reset_query();  
