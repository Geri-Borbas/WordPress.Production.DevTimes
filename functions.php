<?php

// Enqueue styles.
add_action(
    'wp_enqueue_scripts',
    function()
    { wp_enqueue_style('twentyseventeen-devtimes-style', get_template_directory_uri().'/style.css' ); }
);

// "App" post format.
require_once('inc/DevTimes/App.php');
require_once('inc/devtimes.scripts.php');
$app = new DevTimes\App('twentyseventeen-devtimes');

?>