<?php

namespace App\CurrentConditions;

use App\Conditions\WeatherConditions;
use App\HttpClient\IHttpClient;

class OpenWeatherConditionsProvider implements IConditionsProvider
{
    const BASE_URL = 'http://api.openweathermap.org/data/2.5/weather?';
    const API_KEY  = '598a3759e9f51043aaf6e2caa4288b8a';

    /** @var HttpClient */
    private $HttpClient;

    public function __construct(IHttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
    }

    public function getCurrentConditionsForCoordinates(float $long, float $lat): WeatherConditions
    {
        $response = $this->HttpClient->get(self::BASE_URL . "lat={$lat}&lon={$long}&appid=" . self::API_KEY);

        $parsedResponse = json_decode($response->getContent(), true);

        $Conditions = new WeatherConditions;
        $Conditions->provider    = 'OpenWeather';
        $Conditions->temperature = $parsedResponse['main']['feels_like'] - 272.15; //response in K
        $Conditions->humidity    = $parsedResponse['main']['humidity'];
        $Conditions->wind        = $parsedResponse['wind']['speed'];
        $Conditions->type        = $parsedResponse['weather'][0]['id'];

        return $Conditions;
    }

}
