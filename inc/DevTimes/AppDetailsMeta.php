<?php


namespace DevTimes;


require_once('Meta.php');


class AppDetailsMeta extends Meta
{


    // Data.
    public $name;
    public $twitter;
    public $appID_iOS;

    // iTunes.
    public $trackCensoredName;
    public $trackViewUrl;
    public $artworkUrl512;
    public $releaseDate;

    // Meta attributes.
    protected $title = "Details";
    protected $id = "app_details"; // Use this as prefix in template attributes
    protected $template = "AppDetailsMeta.MetaBox.twig";


    protected function render()
    {
        parent::render();

        // Load scripts.
        wp_enqueue_script('qwest.min.js', get_stylesheet_directory_uri().'/js/'.'qwest.min.js');
        wp_enqueue_script('eppz!js.min.js', get_stylesheet_directory_uri().'/js/'.'eppz!js.min.js');
        wp_enqueue_script('AppDetailsMeta.js', get_stylesheet_directory_uri().'/js/'.'AppDetailsMeta.js', array('jquery'), '0.2.0', true);
    }
}