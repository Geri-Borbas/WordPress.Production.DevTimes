<?php


namespace DevTimes;


class AppMeta
{


    public $app_meta_title;
    public $app_meta_developer_twitter;
    public $app_meta_appID_iOS;
    public $app_meta_appID_Android;
    public $app_meta_netHours;
    public $app_meta_grossHours;
    public $app_meta_teamSize;


    function __construct($meta)
    {
        $this->app_meta_title = $meta['app_meta_title'];
        $this->app_meta_developer_twitter = $meta['app_meta_developer_twitter'];
        $this->app_meta_appID_iOS = $meta['app_meta_appID_iOS'];
        $this->app_meta_appID_Android = $meta['app_meta_appID_Android'];
        $this->app_meta_netHours = $meta['app_meta_netHours'];
        $this->app_meta_grossHours = $meta['app_meta_grossHours'];
        $this->app_meta_teamSize = $meta['app_meta_teamSize'];
    }
}