<?php


namespace DevTimes;


require_once('Meta.php');


class AppProjectMeta extends Meta
{


    // Data.
    public $netHours;
    public $grossHours;
    public $teamSize;

    // Meta attributes.
    protected $title = "Project";
    protected $id = "app_project"; // Use this as prefix in template attributes
    protected $template = "AppProjectMeta.MetaBox.twig";
}