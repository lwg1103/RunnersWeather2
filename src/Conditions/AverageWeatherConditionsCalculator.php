<?php

namespace App\Conditions;

use App\Conditions\WeatherConditions;

class AverageWeatherConditionsCalculator
{
    const FLOAT_FIELDS = ['pm10', 'pm25', 'temperature', 'humidity', 'wind'];

    public function calculate(array $conditions): WeatherConditions
    {
        $data = $this->prepareInputData($conditions);

        $averageConditions           = new WeatherConditions;
        $averageConditions->provider = "Averages (calculated)";

        foreach (self::FLOAT_FIELDS as $field)
        {
            if (isset($data[$field]))
            {
                $averageConditions->$field = array_sum($data[$field]) / count($data[$field]);
            }
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

    private function prepareInputData(array $conditions)
    {
        $data = [];
        /** @var WeatherConditions $condition */
        foreach ($conditions as $condition)
        {
            if ($condition->error)
            {
                continue;
            }

            foreach (self::FLOAT_FIELDS as $field)
            {
                if (!is_null($condition->$field))
                {
                    $data[$field][] = $condition->$field;
                }
            }
            $data['type'][] = $condition->type;
        }

        return $data;
    }

}
