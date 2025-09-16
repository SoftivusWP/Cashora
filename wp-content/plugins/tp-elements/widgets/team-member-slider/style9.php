<?php //******************//
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
    $content = get_the_content();									   
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
	$ins ='';
	$ldin ='';

	if($facebook!=''){
		$fb='<a href="'.$facebook.'" class="social-icon"><i class="fab fa-facebook-f"></i></a> ';
	}
	if($twitter!=''){
		$tw='<a href="'.$twitter.'" class="social-icon"><i class="fab fa-twitter"></i></a>';
	}
	if($instagram!=''){
		$ins='<a href="'.$instagram.'" class="social-icon"><i class="fab fa-instagram"></i></a> ';
	}
	if($linkedin!=''){
		$ldin='<a href="'.$linkedin.'" class="social-icon"><i class="fab fa-linkedin-in"></i></a>';
	}
?>

<div class="team-item swiper-slide">
	<div class="single-item position-relative overflow-hidden">
		<?php the_post_thumbnail(); ?>
		<div class="hover-item pb-8 pb-md-20 w-100 px-4 px-md-8 position-absolute bottom-0 cus-z1 d-center justify-content-between">
			<div class="text-item">
				<h4 class="mb-1"><?php the_title();?></h4>
			</div>
		</div>
	</div>
</div>

<?php
endwhile;
wp_reset_query();  
?>  
