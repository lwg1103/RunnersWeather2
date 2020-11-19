<?php

namespace App\Domain\CurrentConditions;

use App\Domain\Conditions\WeatherConditions;

interface IConditionsProvider
{
    public function getCurrentConditionsForCoordinates(float $long, float $lat): WeatherConditions;
}
