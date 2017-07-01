<?php


namespace DevTimes;


class Work
{


    // Data.
    public $name;
    public $role;
    public $months;
    public $hoursPerDay;


    function  __construct($name, $role, $months, $hoursPerDay)
    {
        $this->name = $name;
        $this->role = $role;
        $this->months = $months;
        $this->hoursPerDay = $hoursPerDay;
    }
}