<?php

namespace App\Conditions;

class WeatherType implements \JsonSerializable
{
    const Thunderstorm = 1;
    const Drizzle = 2;
    const Rain = 3;
    const Snow = 4;
    const Clear = 5;
    const Clouds = 6;
    const Other = 7;
    
    /** @var int */
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
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
            case self::Other:
                return 'Other';
        }
    }
    
    public function jsonSerialize()
    {
        return [
            'code' => $this->value,
            'name' => (string) $this,
        ];
    }

}
