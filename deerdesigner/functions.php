<?php

add_action( 'wp_enqueue_scripts', 'enqueue_styles', 11 );
function enqueue_styles() {
    
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );

}

/*
* Adding Custom Post Type
*/
function register_deer_tests_post_type() {
    $args = array(
        'labels' => array(
            'name'          => __('Deer Tests', 'textdomain'),
            'singular_name' => __('Deer Test', 'textdomain'),
            'add_new_item'  => __('Add New Deer Test', 'textdomain'),
            'edit_item'     => __('Edit Deer Test', 'textdomain'),
            'all_items'     => __('All Deer Tests', 'textdomain'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => array('slug' => 'deer-tests'),
        'supports'      => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('deer_tests', $args);
}
add_action('init', 'register_deer_tests_post_type');

/*
* Adding Custom Fields
*/
function deer_tests_add_custom_meta_boxes() {
    add_meta_box(
        'deer_tests_meta_box',
        'Custom Fields',
        'deer_tests_render_meta_box',
        'deer_tests',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'deer_tests_add_custom_meta_boxes');

function deer_tests_render_meta_box($post) {
    // Add nonce for security
    wp_nonce_field('deer_tests_save_meta_box_data', 'deer_tests_meta_box_nonce');

    // Retrieve existing values from the database if they exist
    $start_date      = get_post_meta($post->ID, '_start_date', true);
    $end_date        = get_post_meta($post->ID, '_end_date', true);
    $description     = get_post_meta($post->ID, '_description', true);
    $cover_image     = get_post_meta($post->ID, '_cover_image', true);
    $application_link = get_post_meta($post->ID, '_application_link', true);

    ?>
    <p>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo esc_attr($start_date); ?>" />
    </p>
    <p>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo esc_attr($end_date); ?>" />
    </p>
    <p>
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4"><?php echo esc_textarea($description); ?></textarea>
    </p>
    <p>
        <label for="cover_image">Cover Image</label>
        <input type="text" id="cover_image" name="cover_image" value="<?php echo esc_attr($cover_image); ?>" />
        <button type="button" id="upload_cover_image_button">Upload Image</button>
    </p>
    <p>
        <label for="application_link">Application Link:</label>
        <input type="url" id="application_link" name="application_link" value="<?php echo esc_attr($application_link); ?>" />
    </p>

    <script>
    jQuery(document).ready(function($) {
        $('#upload_cover_image_button').click(function(e) {
            e.preventDefault();
            var custom_uploader = wp.media({
                title: 'Select Cover Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#cover_image').val(attachment.url);
            })
            .open();
        });
    });
    </script>
    <?php
}

function deer_tests_save_meta_box_data($post_id) {
    // Check nonce for security
    if (!isset($_POST['deer_tests_meta_box_nonce']) || !wp_verify_nonce($_POST['deer_tests_meta_box_nonce'], 'deer_tests_save_meta_box_data')) {
        return;
    }

    // Save fields
    $fields = [
        '_start_date'      => 'start_date',
        '_end_date'        => 'end_date',
        '_description'     => 'description',
        '_cover_image'     => 'cover_image',
        '_application_link' => 'application_link',
    ];

    foreach ($fields as $meta_key => $post_key) {
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
        }
    }
}
add_action('save_post', 'deer_tests_save_meta_box_data');
