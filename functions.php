<?php

// add parent and child style
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
}

// Remove Google fonts for Twenty Sixteen
if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
function twentysixteen_fonts_url() {
        return '';
}
endif;

?>
