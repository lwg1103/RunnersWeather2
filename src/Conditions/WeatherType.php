<?php

namespace App\Conditions;

use App\SerializableType;

class WeatherType extends SerializableType
{
    const Thunderstorm = 1;
    const Drizzle = 2;
    const Rain = 3;
    const Snow = 4;
    const Clear = 5;
    const Clouds = 6;
    const Other        = 7;

    public function __toString()
    {
        switch ($this->value) {
            case self::Thunderstorm:
                return 'Thunderstorm';
            case self::Drizzle:
                return 'Drizzle';
            case self::Rain:
                return 'Rain';
            case self::Snow:
                return 'Snow';
            case self::Clear:
                return 'Clear';
            case self::Clouds:
                return 'Clouds';
            default:
                return 'Other';
        }
    }

}
