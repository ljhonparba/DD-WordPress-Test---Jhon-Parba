<?php

get_header();

$args = array(
    'post_type'      => 'deer_tests',
    'posts_per_page' => -1,
);

$deer_tests_query = new WP_Query($args);

echo '<div class="site-main">';
    
    while( $deer_tests_query->have_posts() ) {
        $deer_tests_query->the_post();
        $cover_image = get_post_meta(get_the_ID(), '_cover_image', true);
        ?>
            <a href="<?php echo get_the_permalink();?>" class="item-list" style="background-image: url('<?php echo $cover_image; ?>')">
                <?php echo '<div class="title">'.get_the_title().'</div>'; ?>
            </a>
        <?php
    } wp_reset_postdata();

echo '</div>';

get_footer();