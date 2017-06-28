<?php


namespace DevTimes;


class Meta
{


    protected $key = "meta"; // Prefix
    protected $id = "meta";
    protected $title = "Meta";
    protected $template = "MetaBox.twig";
    protected $screen = "normal";
    protected $priority = "high";

    private $postType;
    private $nonce_key = 'meta_nonce_key';
    private $nonce = 'meta_nonce';


    function  __construct($postType)
    {
        // Set post type.
        $this->postType = $postType;

        // Action hooks.
        add_action(
            'save_post',
            function()
            { $this->save(); }
        );
    }

    public function AddMetaBox()
    {
        add_meta_box(
            $this->id, // Meta box ID (used in the 'id' attribute for the meta box).
            $this->title, // Title of the meta box.
            function()
            { $this->render(); }, // Function that fills the box with the desired content. The function should echo its output.
            $this->postType,
            $this->screen, // Post edit screen contexts include 'normal', 'side', and 'advanced'.
            $this->priority  // The priority within the context where the boxes should show ('high', 'low'). Default 'default'.
        );
    }

    protected function render()
    {
        // Get meta.
        $this->load();

        // Render.
        wp_nonce_field($this->nonce, $this->nonce_key);
        \Timber\Timber::render($this->template, $this->arrayRepresentation());
    }

    protected function load()
    {
        global $post;
        $meta = get_post_meta($post->ID, $this->key, true);

        // Array elements to properties.
        foreach ($meta as $eachKey => $eachValue)
        { $this->$eachKey = $eachValue; }
    }

    function arrayRepresentation()
    { return (array)$this; }

    function save()
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
            if (strpos($eachKey, $this->key) !== false) // Only if prefixed with key
            { $meta[$eachKey] = $eachValue; }
        }

        // UPDATE.
        if(get_post_meta($post->ID, $this->key, true))
        { update_post_meta($post->ID, $this->key, $meta); }

        // CREATE.
        else
        { add_post_meta($post->ID, $this->key, $meta); }

        // DELETE (if no data in $_POST).
        if (!$_POST[$this->key]) delete_post_meta($post->ID, $meta);
    }

}