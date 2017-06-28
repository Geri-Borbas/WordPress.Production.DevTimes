<?php


namespace DevTimes;


require_once('Meta.php');


class AppProjectMeta extends Meta
{

    
    // Attributes.
    protected $key = "app_project";
    protected $id = "app_project";
    protected $title = "Project";
    protected $template = "AppProjectMeta.MetaBox.twig";

    // Data.
    public $app_project_netHours;
    public $app_project_grossHours;
    public $app_project_teamSize;
}