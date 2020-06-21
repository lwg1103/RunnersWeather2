<?php

namespace App\CurrentConditions;

use App\Conditions\WeatherConditions;

interface IConditionsProvider
{
    public function getCurrentConditionsForCoordinates(float $long, float $lat): WeatherConditions;
}
