<?php

namespace App\Domain\Decision;

use App\SerializableType;

class DecisionType extends SerializableType
{
    const OK         = 1;
    const TooCold    = 2;
    const LowSmog    = 3;
    const HeavySmog  = 4;
    const TooHot     = 5;
    const Rain       = 6;
    const BadWeather = 7;
    const StrongWind = 8;

    public function __toString()
    {
        switch ($this->value)
        {
            case self::OK:
                return 'Ok';
            case self::TooCold:
                return 'Too Cold';
            case self::LowSmog:
                return 'Low Smog';
            case self::HeavySmog:
                return 'Heavy Smog';
            case self::TooHot:
                return 'Too Hot';
            case self::Rain:
                return 'Rain';
            case self::BadWeather:
                return 'Bad Weather';
            case self::StrongWind:
                return 'Strong Wind';
            default:
                return 'Other';
        }
    }

}
