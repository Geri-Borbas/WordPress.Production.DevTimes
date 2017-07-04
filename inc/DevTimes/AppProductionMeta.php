<?php


namespace DevTimes;


require_once('Meta.php');
require_once('Work.php');


class AppProductionMeta extends Meta
{


    // Data.
    public $netHours;
    public $grossHours;
    public $teamSize;
    public $work;


    // Meta attributes.
    protected $title = "Production";
    protected $id = "app_production"; // Use this as prefix in template attributes
    protected $fallback_id = "app_project";
    protected $template = "AppProductionMeta.MetaBox.twig";


    function  __construct($postType)
    {
        parent::__construct($postType);

        // Dummy data.
        $this->work = array
        (
            new Work('Batman', 'UX design', '3 months', '6 hours/day'),
            new Work('Superman', 'UI design', '4 months', '6 hours/day'),
            new Work('Spiderman', 'UID', '3 months', '6 hours/day')
        );
    }

    function render()
    {
        parent::render();

        // Load scripts.
        wp_enqueue_script('qwest.min.js', get_stylesheet_directory_uri().'/js/'.'qwest.min.js');
        wp_enqueue_script('eppz!js.min.js', get_stylesheet_directory_uri().'/js/'.'eppz!js.min.js');
        wp_enqueue_script('AppProductionMeta.js', get_stylesheet_directory_uri().'/js/'.'AppProductionMeta.js', array('jquery'), '0.3.8', true);
    }

    function prefixedArrayOfPublicPropertiesAndValues()
    {
        $publicPropertiesAndValues = parent::prefixedArrayOfPublicPropertiesAndValues();

        // May (!) inject indices for `Work` instances.

        return $publicPropertiesAndValues;
    }
}