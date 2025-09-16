<?php

/**
 * Template for displaying content of a single event.
 *
 * This template can be overridden by copying it to your theme and modifying it as necessary.
 *
 * @package Edufast
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Fetch event details
$event_id = get_the_ID();
$start_datetime = tribe_get_start_date($event_id, false, 'Y-m-d H:i:s');
$end_datetime = tribe_get_end_date($event_id, false, 'Y-m-d H:i:s');
$venue = tribe_get_venue($event_id);
$address = tribe_get_address($event_id);
$organizer = tribe_get_organizer($event_id);
$categories = get_the_terms($event_id, 'tribe_events_cat');
$_EventCost = tribe_get_cost($event_id, true);

?>

<section class="event-details position-relative">
    <div class="container container1600">
        <div class="event-details-wrap position-relative">
            <div class="thumb-event position-relative mb-sm-0 mb-2">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full', array('class' => 'w-100')); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container mt-70">
        <div class="row ">
            <div class="col-lg-8">
                <div class="event-details-left ">
                    <h2 class="event-details-title">
                        <?php the_title(); ?>
                    </h2>
                    <div class="event-details-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="event-sidebar pixelaxis-sideabr dynamic-sidebar">
                    <div class="event-meta widget">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="sidebar_thumb position-relative">
                                <?php the_post_thumbnail('full', array('class' => 'w-100 radius32 mimg')); ?>

                                <?php if ($_EventCost) : ?>
                                    <span class="event_price"><?php echo esc_html($_EventCost); ?></span>
                                <?php else : ?>
                                    <span class="event_price"><?php echo esc_html__('Free', 'cashora'); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <ul class="tp-event-sidebar-info">
                            <?php if( !empty( $start_datetime ) ) : ?>
                            <li class="tp-event-sidebar-info-single">
                                <strong><i class="tp tp-clock-regular"></i> <?php echo esc_html( 'Start Date:', 'cashora' ); ?></strong>
                                <?php echo date('F j, Y', strtotime($start_datetime)); ?>
                            </li>
                            <?php endif; ?>
                            <?php if( !empty( $end_datetime ) ) : ?>
                            <li class="tp-event-sidebar-info-single">
                                <strong><i class="tp tp-clock-regular"></i> <?php echo esc_html( 'End Date:', 'cashora' ); ?></strong>
                                <?php echo date('F j, Y', strtotime($end_datetime)); ?>
                            </li>
                            <?php endif; ?>
                            <?php if( !empty( $venue ) ) : ?>
                            <li class="tp-event-sidebar-info-single">
                                <strong><i class="tp tp-map-location-dot"></i> <?php echo esc_html__('Venue:', 'cashora'); ?></strong>
                                <?php echo esc_html($venue); ?>
                            </li>
                            <?php endif; ?>
                            <?php if( !empty( $address ) ) : ?>
                            <li class="tp-event-sidebar-info-single">
                                <strong><i class="tp tp-heart-1"></i> <?php echo esc_html__('Address:', 'cashora'); ?></strong>
                                <?php echo esc_html($address); ?>
                            </li>
                            <?php endif; ?>
                            <?php if( !empty( $organizer ) ) : ?>
                            <li class="tp-event-sidebar-info-single">
                                <strong><i class="tp tp-list"></i> <?php echo esc_html__('Organizer:', 'cashora'); ?></strong>
                                <?php echo esc_html($organizer); ?>
                            </li>
                            <?php endif; ?>
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <li class="tp-event-sidebar-info-single">
                                    <strong><?php echo esc_html__('Categories:', 'cashora'); ?></strong>
                                    <?php foreach ($categories as $category) : ?>
                                        <?php echo esc_html($category->name); ?>
                                    <?php endforeach; ?>
                                </li>
                            <?php endif; ?>
                            <li>
                                <div class="tp-event-social">
                                    <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode($event_id); ?>" target="_blank">
                                        <i class="tp tp-facebook-f"></i>
                                    </a>
                                    <a href="https://instagram.com/?url=<?php echo urlencode($event_id); ?>" target="_blank">
                                        <i class="tp tp-instagram"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($event_id); ?>" target="_blank">
                                        <i class="tp tp-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($event_id); ?>" target="_blank">
                                        <i class="tp tp-linkedin-in"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>


                    </div>

                </div>
            </div>
        </div>


        <div class="row mt-70-i">
            <div class="col-12">


                <div class="tp-after-meta-events">
                <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
                </div>

                
                <div class="tp-before-meta-events">
                <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
                </div>

                <div class="tp-tribe-events-wrapper">

                    <!-- Event meta -->
                    <?php //do_action( 'tribe_events_single_event_before_the_meta' ) ?>
                    <?php tribe_get_template_part( 'modules/meta' ); ?>
                    <?php //do_action( 'tribe_events_single_event_after_the_meta' ) ?>

                </div>

            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <div class="tp-tribe-events-pagination">
                    <!-- Event footer -->
                    <div id="tribe-events-footer">
                        <!-- Navigation -->
                        <nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'cashora' ), $events_label_singular ); ?>">
                            <ul class="tribe-events-sub-nav">
                                <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                                <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
                            </ul>
                            <!-- .tribe-events-sub-nav -->
                        </nav>
                    </div>
                    <!-- #tribe-events-footer -->
                </div>
            </div>
        </div>


    </div>
</section>

