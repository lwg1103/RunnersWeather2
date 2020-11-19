<?php

namespace App\Domain\Conditions;

use App\Domain\Conditions\WeatherConditions;

class AverageWeatherConditionsCalculator
{
    const FLOAT_FIELDS = ['pm10', 'pm25', 'temperature', 'humidity', 'wind'];

    public function calculate(array $conditions): WeatherConditions
    {
        $data = $this->prepareInputData($conditions);

        $averageConditions           = new WeatherConditions;
        $averageConditions->provider = "Averages (calculated)";

        $this->calculateFloatFields($averageConditions, $data)
                ->rewriteInfoFields($averageConditions, $data);

        return $averageConditions;
    }

    private function prepareInputData(array $conditions): array
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
            $data['datetime'][] = $condition->datetime;
        }

        return $data;
    }
    
    private function calculateFloatFields(WeatherConditions $averageConditions, array $data)
    {
        foreach (self::FLOAT_FIELDS as $field)
        {
            if (isset($data[$field]))
            {
                $averageConditions->$field = array_sum($data[$field]) / count($data[$field]);
            }
        }
        
        return $this;
    }
    
    private function rewriteInfoFields(WeatherConditions $averageConditions, array $data)
    {
        foreach ($data['type'] as $type)
        {
            if ($type->getValue() !== 0)
            {
                $averageConditions->type = $type;
                break;
            }
        }
        
        foreach ($data['datetime'] as $datetime)
        {
            $averageConditions->datetime = $datetime;
        }
        
        return $this;
    }

}
