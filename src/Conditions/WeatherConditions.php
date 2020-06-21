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
    
    /** @var string */
    public $type;
    
    /** @var int */
    public $recommendation;
    
    public function toJSON()
    {
        return json_encode($this);
    }
}
