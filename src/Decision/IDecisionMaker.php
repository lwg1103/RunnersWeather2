<?php

namespace App\Decision;

use App\Conditions\WeatherConditions;

interface IDecisionMaker
{
    public function checkWeatherForRunning(WeatherConditions $conditions): DecisionType;
}
