<?php
// From https://codex.wordpress.org/Child_Themes
function devtimes_enqueue_styles()
{
    $parent_style = 'twentyseventeen-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
    	'devtimes-style', // child-style
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'devtimes_enqueue_styles' );

require_once('inc/devtimes.app.php');

?>