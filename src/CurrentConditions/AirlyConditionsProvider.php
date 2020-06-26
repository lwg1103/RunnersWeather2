<?php

namespace App\CurrentConditions;

use App\Conditions\WeatherConditions;
use App\HttpClient\IHttpClient;

class AirlyConditionsProvider implements IConditionsProvider
{
    const APIKey = "";
    const URL    = "https://airapi.airly.eu/v2/measurements/point?";

    /** @var HttpClient */
    private $HttpClient;

    public function __construct(IHttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
        $this->HttpClient->setApiKey(self::APIKey);
    }

    public function getCurrentConditionsForCoordinates(float $long, float $lat): WeatherConditions
    {
        
    }

}
