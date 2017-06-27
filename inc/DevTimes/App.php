<?php


namespace DevTimes;


require_once('AppMeta.php');


class App
{


    private $postType = 'app-post-type';
    private $singular = 'App';
    private $plural = 'Apps';
    private $description = 'Applications';
    private $slug = 'app';

    private $nonce_key = 'app_nonce_key';
    private $nonce = 'app_nonce';
    private $meta_key = "app_meta";

    // Construction time.
    private $textdomain;


    function __construct($textdomain)
    {
        // Set text domain.
        $this->textdomain = $textdomain;

        // Action hooks.
        add_action(
            'init',
            function()
            { $this->register_taxonomy_with_name('Tool', 'Tools'); }
        );
        add_action(
            'init',
            function()
            { $this->register_taxonomy_with_name('Platform', 'Platforms'); }
        );
        add_action(
            'init',
            function()
            { $this->register_post_type(); }
        );
        add_action(
            'save_post',
            function()
            { $this->save_post($this->meta_key); }
        );
    }

    function register_taxonomy_with_name($taxonomy_singular, $taxonomy_plural, $hierarchical = false)
    {
        register_taxonomy
        (
            strtolower($taxonomy_singular),
            array($this->postType),
            array
            (
                'labels' => array
                (
                    'name' => __($taxonomy_plural, $this->textdomain),
                    'singular_name' => __($taxonomy_singular, $this->textdomain),
                    'add_new_item' => __('Add ' . strtolower($taxonomy_singular), $this->textdomain),
                    'separate_items_with_commas' => __('Separate ' . strtolower($taxonomy_plural) . ' with commas', $this->textdomain),
                    'add_or_remove_items' => __('Add or remove ' . strtolower($taxonomy_plural), $this->textdomain),
                    'choose_from_most_used' => __('Choose from the most used ' . strtolower($taxonomy_plural), $this->textdomain),
                ),
                'hierarchical' => $hierarchical,
                'show_ui' => true,
                'rewrite' => array('slug' => __(strtolower($taxonomy_singular), $this->textdomain)),
                'query_var' => true,
            )
        );
    }

    function register_post_type()
    {
        register_post_type
        (
            $this->postType,
            array
            (
                'label' => __($this->plural, $this->textdomain),
                'singular_label' => __($this->singular, $this->textdomain),
                'description' => __($this->description, $this->textdomain),

                // UI.
                'menu_position' => 5,
                'menu_icon' => 'dashicons-tablet',
                'labels' => array
                (
                    'name' => __($this->plural, $this->textdomain),
                    'singular_name' => __($this->singular, $this->textdomain),
                    'menu_name' => __($this->plural, $this->textdomain),
                    'parent_item_colon' => __('Parent ' . $this->singular, $this->textdomain),
                    'all_items' => __('All ' . $this->plural, $this->textdomain),
                    'view_item' => __('View ' . $this->singular, $this->textdomain),
                    'add_new_item' => __('Add New ' . $this->singular, $this->textdomain),
                    'add_new' => __('Add New', $this->textdomain),
                    'edit_item' => __('Edit ' . $this->singular, $this->textdomain),
                    'update_item' => __('Update ' . $this->singular, $this->textdomain),
                    'search_items' => __('Search ' . $this->singular, $this->textdomain),
                    'not_found' => __('Not Found', $this->textdomain),
                    'not_found_in_trash' => __('Not found in Trash', $this->textdomain),
                ),

                // Features.
                'supports' => array
                (
                    'title',
                    'author'
                ),

                // Attributes.
                'public' => true,
                'taxonomies' => array('platform', 'tools'),
                'has_archive' => true,
                'show_ui' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'rewrite' => array('slug' => __($this->slug, $this->textdomain)),

                // Meta boxes.
                'register_meta_box_cb' => array($this, 'register_meta_boxes')
            )
        );
    }

    function register_meta_boxes()
    {
        add_meta_box(
            'app_times', // Meta box ID (used in the 'id' attribute for the meta box).
            'Times', // Title of the meta box.
            function() // Function that fills the box with the desired content. The function should echo its output.
            {
                $this->render_meta_box
                (
                    $this->meta_key,
                    'App.MetaBox.twig'
                );
            },
            $this->postType,
            'normal', // Post edit screen contexts include 'normal', 'side', and 'advanced'.
            'high'  // The priority within the context where the boxes should show ('high', 'low'). Default 'default'.
        );
    }

    function render_meta_box($key, $template)
    {
        // Get meta.
        $appMeta = AppMeta::parse($key);

        // Render.
        wp_nonce_field($this->nonce, $this->nonce_key);
        \Timber\Timber::render($template, $appMeta);
    }

    function save_post($key)
    {
        global $post;

        // Checks.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset( $_POST[$this->nonce_key] ) || !wp_verify_nonce($_POST[$this->nonce_key], $this->nonce)) return;
        if(!current_user_can('edit_post', $post->ID)) return;

        // Get prefixed fields from $_POST.
        $meta = array();
        foreach($_POST as $eachKey => $eachValue)
        {
            if (strpos($eachKey, $key) !== false) // Only if prefixed with key
            { $meta[$eachKey] = $eachValue; }
        }

        // UPDATE.
        if(get_post_meta($post->ID, $key, true))
        { update_post_meta($post->ID, $key, $meta); }

        // CREATE.
        else
        { add_post_meta($post->ID, $key, $meta); }

        // DELETE (if no data in $_POST).
        if (!$_POST[$key]) delete_post_meta($post->ID, $meta);
    }
}