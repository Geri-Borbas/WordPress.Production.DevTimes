<?php

// Enqueue styles.
add_action(
    'wp_enqueue_scripts',
    function()
    { wp_enqueue_style('twentyseventeen-devtimes-style', get_template_directory_uri().'/style.css' ); }
);

// Enqueue admin styles.
add_action(
    'admin_enqueue_scripts',
    function()
    {
        wp_register_style('twentyseventeen-devtimes-admin-style', get_stylesheet_directory_uri().'/css/admin/index.css', false, '0.2.3' );
        wp_enqueue_style('twentyseventeen-devtimes-admin-style');
    }
);

// "App" post format.
require_once('inc/DevTimes/App.php');
$app = new DevTimes\App('twentyseventeen-devtimes');

?>