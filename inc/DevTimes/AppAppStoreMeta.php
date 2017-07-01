<?php


namespace DevTimes;


require_once('Meta.php');


class AppAppStoreMeta extends Meta
{


    // Data.
    public $name;
    public $twitter;
    public $appID;

    // iTunes.
    public $trackCensoredName;
    public $trackViewUrl;
    public $artworkUrl512;
    public $releaseDate;

    // Meta attributes.
    protected $title = " App Store";
    protected $id = "app_appstore"; // Use this as prefix in template attributes
    protected $fallback_id = "app_details";
    protected $template = "AppAppStoreMeta.MetaBox.twig";


    protected function render()
    {
        parent::render();

        // Load scripts.
        wp_enqueue_script('qwest.min.js', get_stylesheet_directory_uri().'/js/'.'qwest.min.js');
        wp_enqueue_script('eppz!js.min.js', get_stylesheet_directory_uri().'/js/'.'eppz!js.min.js');
        wp_enqueue_script('AppAppStoreMeta.js', get_stylesheet_directory_uri().'/js/'.'AppAppStoreMeta.js', array('jquery'), '0.2.0', true);
    }
}