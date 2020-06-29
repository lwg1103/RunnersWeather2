<?php

namespace App\Decision;

use App\Conditions\WeatherConditions;
use App\Conditions\WeatherType;

class DecisionMaker implements IDecisionMaker
{
    public function checkWeatherForRunning(WeatherConditions $conditions): DecisionType
    {
        /*
         * NO GO SECTION *
         */
        if ($conditions->pm25 > 50)
        {
            return new DecisionType(DecisionType::HeavySmog);
        }
        else if ($conditions->temperature < 0)
        {
            return new DecisionType(DecisionType::TooCold);
        }
        else if ($conditions->temperature >= 30 && $this->calculateHeatFactor($conditions) >= 45)
        {
            return new DecisionType(DecisionType::TooHot);
        }
        else if ($conditions->wind >= 10)
        {
            return new DecisionType(DecisionType::StrongWind);
        }

        switch ($conditions->type->getValue())
        {
            case WeatherType::Rain:
            case WeatherType::Snow:
            case WeatherType::Thunderstorm:
                return new DecisionType(DecisionType::Rain);
        }

        /*
         * MID SECTION 
         */
        if ($conditions->pm25 > 25 && $conditions->pm25 <= 50)
        {
            return new DecisionType(DecisionType::LowSmog);
        }

        switch ($conditions->type->getValue())
        {
            case WeatherType::Drizzle:
            case WeatherType::Other:
                return new DecisionType(DecisionType::BadWeather);
        }

        /*
         * OK SECTION
         */
        return new DecisionType(DecisionType::OK);
    }

    private function calculateHeatFactor(WeatherConditions $conditions): float
    {
        $temp = is_null($conditions->temperature) ? 0 : $conditions->temperature;
        $hum  = is_null($conditions->humidity) ? 0 : $conditions->humidity;

        return round($temp * 0.9 + $hum * 0.25);
    }

}
