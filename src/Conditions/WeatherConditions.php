<?php

namespace App\Conditions;

class WeatherConditions
{
    /** @var string */
    public $provider = 'unknown';
    
    /** @var float */
    public $pm25;
    
    /** @var float */
    public $pm10;
    
    /** @var float */
    public $temperature;
    
    /** @var float */
    public $humidity;
    
    /** @var float */
    public $wind;
    
    /** @var WeatherType */
    public $type;
    /** @var int */
    public $recommendation;

    public function __construct()
    {
        $this->type = new WeatherType(0);
    }

    public function toJSON()
    {
        return json_encode($this);
    }
}
