<?php

get_header();

echo '<div class="site-main">';
    if( have_posts() ) {
        the_post();

            echo get_the_title();

        the_content();
    }
echo '</div>';

get_footer();