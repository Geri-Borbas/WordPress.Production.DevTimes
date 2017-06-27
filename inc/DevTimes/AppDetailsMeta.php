<?php


namespace DevTimes;


require_once('Meta.php');


class AppDetailsMeta extends Meta
{


    // Attributes.
    protected $key = "app_meta";
    protected $id = "app_times";
    protected $title = "Times";
    protected $template = "App.Details.MetaBox.twig";

    // Data.
    public $app_meta_title;
    public $app_meta_developer_twitter;
    public $app_meta_appID_iOS;
    public $app_meta_appID_Android;
    public $app_meta_netHours;
    public $app_meta_grossHours;
    public $app_meta_teamSize;
}