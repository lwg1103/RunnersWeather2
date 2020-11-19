<?php

namespace App\Domain\Conditions;

use App\Domain\Decision\DecisionType;

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
    /** @var DecisionType */
    public $decision;
    /** @var DateTime */
    public $datetime;
    /** @var bool */
    public $error    = false;

    public function __construct()
    {
        $this->type     = new WeatherType(0);
        $this->decision = new DecisionType(0);

        $this->datetime = new \DateTime;
    }

}
