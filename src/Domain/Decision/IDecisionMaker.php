<?php

namespace App\Domain\Decision;

use App\Domain\Conditions\WeatherConditions;

interface IDecisionMaker
{
    public function checkWeatherForRunning(WeatherConditions $conditions): DecisionType;
}
