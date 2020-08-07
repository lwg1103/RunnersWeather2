<?php

namespace App\CurrentConditions;

use App\Conditions\WeatherConditions;
use App\HttpClient\IHttpClient;

class AirlyConditionsProvider implements IConditionsProvider
{
    const URL = "https://airapi.airly.eu/v2/measurements/point?";

    /** @var HttpClient */
    private $HttpClient;

    public function __construct(IHttpClient $HttpClient, string $apiKey)
    {
        $this->HttpClient = $HttpClient;
        $this->HttpClient->setApiKey($apiKey);
    }

    public function getCurrentConditionsForCoordinates(float $long, float $lat): WeatherConditions
    {
        $response = $this->HttpClient->get(self::URL . "lat={$lat}&lng={$long}");

        $parsedResponse = json_decode($response->getContent(), true);

        $Conditions           = new WeatherConditions;
        $Conditions->provider = 'Airly';
        $Conditions->error    = true;

        foreach ($parsedResponse['current']['values'] as $valueRow)
        {
            switch ($valueRow['name'])
            {
                case 'PM25':
                    $Conditions->pm25        = $valueRow['value'];
                    $Conditions->error       = false;
                    break;
                case 'PM10':
                    $Conditions->pm10        = $valueRow['value'];
                    $Conditions->error       = false;
                    break;
                case 'HUMIDITY':
                    $Conditions->humidity    = $valueRow['value'];
                    $Conditions->error       = false;
                    break;
                case 'TEMPERATURE':
                    $Conditions->temperature = $valueRow['value'];
                    $Conditions->error       = false;
                    break;
            }
        }

        return $Conditions;
    }

}
