<?php


namespace DevTimes;


require_once('Meta.php');


class AppProductionMeta extends Meta
{


    // Data.
    public $netHours;
    public $grossHours;
    public $teamSize;

    // Meta attributes.
    protected $title = "Production";
    protected $id = "app_production"; // Use this as prefix in template attributes
    protected $fallback_id = "app_project";
    protected $template = "AppProductionMeta.MetaBox.twig";
}