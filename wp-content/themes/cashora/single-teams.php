<?php
    get_header();
    global $cashora_option;
	//take metafield value            

    $designation     = get_post_meta( get_the_ID(), 'designation', true );                                   
    $facebook        = get_post_meta( get_the_ID(), 'facebook', true );
    $twitter         = get_post_meta( get_the_ID(), 'twitter', true );
    $instagram       = get_post_meta( get_the_ID(), 'instagram', true );
    $linkedin        = get_post_meta( get_the_ID(), 'linkedin', true );
    $team_desination = get_post_meta( get_the_ID(), 'designation', true );  
    $short_desc      = get_post_meta( get_the_ID(), 'shortbio', true );

    // Get the group field values
    $group_field_values = get_post_meta( get_the_ID(), 'member_skill', true );
    ?>

<div class="container">
    <?php while ( have_posts() ) : the_post(); ?>

    <div class="row gy-7 gy-lg-0 align-items-center justify-content-between our-team-details">
        <div class="col-xxl-6 col-md-6 mb-6 mb-xl-0 ">
            <div class="image-area mb-40">
                <?php the_post_thumbnail(); ?>
            </div>
        </div>
        <div class="col-xxl-5 col-md-6">
            <h2 class="heading s2-color mb-10"><?php echo esc_html__( 'Hello, I\'m ', 'cashora' ); ?><?php the_title(); ?></h2>
            <?php if($designation) : ?>
            <p class="p1-color fw-bold mb-3 mb-md-6"><?php echo esc_html( $designation ); ?></p>
            <?php endif; ?>
            <div class="social-skills d-grid gap-5 gap-md-8 mb-40">
                <ul class="d-flex gap-3 social-area second">
                    <li>
                        <a href="<?php echo esc_url( $facebook ); ?>" aria-label="Facebook" class="d-center cus-border rounded-0 border b-fourth">
                            <i class="tp tp-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( $twitter ); ?>" aria-label="Twitter" class="d-center cus-border rounded-0 border b-fourth">
                            <i class="tp tp-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( $instagram ); ?>" aria-label="Instagram" class="d-center cus-border rounded-0 border b-fourth">
                            <i class="tp tp-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( $linkedin ); ?>" aria-label="dribbble" class="d-center cus-border rounded-0 border b-fourth">
                            <i class="tp tp-linkedin-in"></i>
                        </a>
                    </li>
                </ul>
                <div class="description d-grid gap-2 gap-md-3">
                    <p class="s2-color"><?php echo esc_html($short_desc); ?></p>
                </div>

                <?php if( !empty( $group_field_values ) ) : ?>
                <div class="d-grid gap-4 gap-md-6">
                    <?php foreach ( $group_field_values as $group_item ) : 
                        $progress_label = $group_item['skill_title'];
                        $progress_value = $group_item['skill_level'];
                    ?>
                    <div class="progress-area">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fw-bold s2-color"><?php echo esc_html( $progress_label ); ?></span>
                            <span class="progress-value fw-bold s2-color"><?php echo esc_html( $progress_value ); ?>%</span>
                        </div>
                        <div class="progress align-items-center">
                            <div class="progress-bar w-<?php echo esc_attr( $progress_value ); ?>" role="progressbar" aria-valuenow="<?php echo esc_attr( $progress_value ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>


    <?php endwhile; ?>

    <?php the_content();?>
<!-- Single Team End -->
</div>




<?php
get_footer();