<?php

get_header();

echo '<div class="site-main">';
    if( have_posts() ) {
        while( have_posts() ) {
            the_post();

            $start_date      = get_post_meta(get_the_ID(), '_start_date', true);
            $end_date        = get_post_meta(get_the_ID(), '_end_date', true);
            $description     = get_post_meta(get_the_ID(), '_description', true);
            $cover_image     = get_post_meta(get_the_ID(), '_cover_image', true);
            $application_link = get_post_meta(get_the_ID(), '_application_link', true);
            ?>
                <div class="dd-container" style="background-image: url('<?php echo $cover_image; ?>');">
                    <div class="title"><a href="<?php echo $application_link; ?>" target="_blank"><?php echo get_the_title(); ?></a></div>
                    <div class="info-box-container">
                        <div class="info-box">
                            <div class="lbl">Start Date:</div>
                            <div class="val"><?php echo $start_date; ?></div>
                        </div>
                        <div class="info-box">
                            <div class="lbl">End Date:</div>
                            <div class="val"><?php echo $end_date; ?></div>
                        </div>
                        <div class="info-box">
                            <div class="lbl">Description:</div>
                            <div class="val"><?php echo $description; ?></div>
                        </div>
                    </div>
                    
                </div>
            <?php
        }
    }
echo '</div>';

get_footer();