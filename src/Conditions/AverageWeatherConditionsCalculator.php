<?php

namespace App\Conditions;

use App\Conditions\WeatherConditions;

class AverageWeatherConditionsCalculator
{
    const FLOAT_FIELDS = ['pm10', 'pm25', 'temperature', 'humidity', 'wind'];

    public function calculate(array $conditions): WeatherConditions
    {
        $data = [];
        /** @var WeatherConditions $condition */
        foreach ($conditions as $condition)
        {
            foreach (self::FLOAT_FIELDS as $field)
            {
                if (!is_null($condition->$field))
                {
                    $data[$field][] = $condition->$field;
                }
            }
            $data['type'][] = $condition->type;
        }

        $averageConditions           = new WeatherConditions;
        $averageConditions->provider = "Averages (calculated)";

        foreach (self::FLOAT_FIELDS as $field)
        {
            $averageConditions->$field = array_sum($data[$field]) / count($data[$field]);
        }
        
        foreach ($data['type'] as $type)
        {
            if ($type->getValue() !== 0)
            {
                $averageConditions->type = $type;
                break;
            }
        }

        return $averageConditions;
    }

}
