<?php

// Enqueue styles.
add_action(
    'wp_enqueue_scripts',
    function()
    { wp_enqueue_style('twentyseventeen-devtimes-style', get_template_directory_uri().'/style.css' ); }
);

?>