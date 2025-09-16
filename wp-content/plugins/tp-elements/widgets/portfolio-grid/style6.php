
<?php 
 $cat = $settings['portfolio_category']; 
 if(empty($cat)){
 	$best_wp = new wp_Query(array(
			'post_type'      => 'tp-portfolios',
			'posts_per_page' => $settings['per_page'],								
	));	  
 }   
 else{
 	$best_wp = new wp_Query(array(
		'post_type'      => 'tp-portfolios',
		'posts_per_page' => $settings['per_page'],				
		'tax_query'      => array(
	        array(
				'taxonomy' => 'tp-portfolio-category',
				'field'    => 'slug', //can be set to ID
					'terms'    => $cat //if field is ID you can reference by cat/term number
	        ),
	    )
	));	  
 }
 ?>
 <div class="list-image">	
	<?php
	$x = 1;
	while($best_wp->have_posts()): $best_wp->the_post();	
							
	 if(has_post_thumbnail()): ?>
			 <div id="item-<?php echo $x;?>" class="portfolio-img tabcontent">
				 <a href="<?php the_permalink();?>"><?php  the_post_thumbnail($settings['thumbnail_size']);?></a>
				 
			 </div>
		 <?php endif;	
		 $x++;
	endwhile;
	wp_reset_query();  
	?>
</div>	 
 <?php
	$x = 1;
	while($best_wp->have_posts()): $best_wp->the_post();	
	$cats_show = get_the_term_list( $best_wp->ID, 'tp-portfolio-category', ' ', '<span class="separator">,</span> ');	
	$termsArray  = get_the_terms( $best_wp->ID, 'tp-portfolio-category' );  //Get the terms for this particular item
	$termsString = ""; //initialize the string that will contain the terms
	$termsSlug   = "";

	foreach ( $termsArray as $term ) { 
		$termsString .= 'filter_'.$term->slug.' '; 
		$termsSlug .= $term->name;
	}								
?>	

	<div class="col-lg-8  offset-lg-4 main-content-wrapper-s-service grid-item">		
		<div class="single-varticle-product tablinks active item-<?php echo $x;?>"  onmouseover="openProject(event, 'item-<?php echo $x;?>')">
				<div class="name-area">
					<span>0<?php echo $x; ?></span>
					<?php if(get_the_title()):?>
						<h4 class="p-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
					<?php endif;?>
				</div>
				<div class="mid-disc">					
					<span class="p-category"><?php echo wp_kses_post($cats_show); ?></span>					
				</div>
				<div class="end">
					<a class="pf-btn" href="<?php the_permalink();?>"><i class="tp-arrow-up-right"></i></a>
				</div>
		</div>
	</div>
<?php	
$x++;
endwhile;
wp_reset_query();  
?>
<script>
	function openProject(evt, cityName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");		
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
</script>