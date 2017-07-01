<?php


namespace DevTimes;


class Inspector
{


    public static function get_object_public_vars($object)
    { return get_object_vars($object); }
}


class Meta
{


    protected $title = "Meta";
    protected $id = "meta"; // Use this as prefix in template attributes
    protected $fallback_id = "meta"; // Use this as prefix in template attributes
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

        // Set template location.
        \Timber\Timber::$dirname = 'templates';
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
        \Timber\Timber::render(
            $this->template,
            $this->prefixedArrayOfPublicPropertiesAndValues()
        );
    }

    protected function load()
    {
        global $post;

        // echo '<pre>';
        // print_r($_POST);

        // Populate public properties from meta.
        $properties = $this->getPublicPropertiesAndValues();
        foreach ($properties as $eachPropertyName => $eachPropertyValue)
        {
            // Load.
            $eachMetaKey = $this->id."_".$eachPropertyName;
            $eachValue = get_post_meta($post->ID, $eachMetaKey, true);

            // If no data, attempt to load meta using `fallback_id`.
            if (!$eachValue)
            {
                $eachMetaKey = $this->fallback_id."_".$eachPropertyName;
                $eachValue = get_post_meta($post->ID, $eachMetaKey, true);
            }

            // Set.
            $this->$eachPropertyName = $eachValue;

            // echo 'Set `'.$eachPropertyName.'`'.' to meta `'.$eachMetaKey.'`.'.PHP_EOL;
        }

        // echo '</pre>';
    }

    function getPublicPropertiesAndValues()
    {
        $publicPropertiesAndValues = Inspector::get_object_public_vars($this);
        // echo '<pre>';
        // print_r($publicPropertiesAndValues);
        // echo '</pre>';
        return $publicPropertiesAndValues;
    }

    function prefixedArrayOfPublicPropertiesAndValues()
    {
        $publicPropertiesAndValues = Inspector::get_object_public_vars($this);
        foreach($publicPropertiesAndValues as $eachKey => $eachValue)
        {
            $publicPropertiesAndValues[$this->id.'_'.$eachKey] = $eachValue; // Prefix
            unset($publicPropertiesAndValues[$eachKey]); // Unset unprefixed
        }
        return $publicPropertiesAndValues;
    }

    function save()
    {
        global $post;

        // Checks.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset( $_POST[$this->nonce_key] ) || !wp_verify_nonce($_POST[$this->nonce_key], $this->nonce)) return;
        if(!current_user_can('edit_post', $post->ID)) return;

        //Update corresponding $_POST values in meta.
        foreach($_POST as $eachKey => $eachValue)
        {
            if (strpos($eachKey, $this->id) !== false) // Only if prefixed with key
            { $this->updateMeta($post->ID, $eachKey, $eachValue); }
        }
    }

    function updateMeta($postID, $key, $value)
    {
        // UPDATE.
        if(get_post_meta($postID, $key, true))
        { update_post_meta($postID, $key, $value); }

        // CREATE.
        else
        { add_post_meta($postID, $key, $value); }

        // DELETE (if no data in $_POST).
        if (!$_POST[$key]) delete_post_meta($postID, $key);
    }
}