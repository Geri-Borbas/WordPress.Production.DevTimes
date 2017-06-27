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


    static function parse($key)
    {
        global $post;
        $meta = get_post_meta($post->ID, $key, true);
        $appMeta = new AppMeta($meta);
        return (array)$appMeta;
    }

    function __construct($meta)
    {
        // Array elements to properties.
        foreach ($meta as $eachKey => $eachValue)
        { $this->$eachKey = $eachValue; }
    }


}