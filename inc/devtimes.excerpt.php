<?php


function devtimes_excerpt_filter($excerpt)
{
    return Timber::fetch(
        'devtimes.excerpt.twig',
        array
        (
            'title' => get_the_title(),
            'thumbnailHTML' => get_the_post_thumbnail(),
            'excerpt' => $excerpt,
            'permalink' => get_permalink(),
        )
    );
}

// add_filter('get_the_excerpt', 'devtimes_excerpt_filter');