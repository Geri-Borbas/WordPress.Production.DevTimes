<?php


namespace DevTimes;


require_once('Meta.php');


class AppDetailsMeta extends Meta
{


    // Attributes.
    protected $key = "app_meta";
    protected $id = "app_times";
    protected $title = "Times";
    protected $template = "AppDetailsMeta.MetaBox.twig";

    // Data.
    public $app_meta_title;
    public $app_meta_developer_twitter;
    public $app_meta_appID_iOS;
    public $app_meta_appID_Android;
    public $app_meta_netHours;
    public $app_meta_grossHours;
    public $app_meta_teamSize;

    // iTunes.
    public $app_meta_trackCensoredName;
    public $app_meta_trackViewUrl;
    public $app_meta_artworkUrl512;
    public $app_meta_releaseDate;


    protected function render()
    {
        parent::render();

        // Load scripts.
        wp_enqueue_script('qwest.min.js', get_stylesheet_directory_uri().'/js/'.'qwest.min.js');
        wp_enqueue_script('eppz!js.min.js', get_stylesheet_directory_uri().'/js/'.'eppz!js.min.js');
        wp_enqueue_script('AppDetailsMeta.js', get_stylesheet_directory_uri().'/js/'.'AppDetailsMeta.js', array('jquery'), null, true);
    }
}