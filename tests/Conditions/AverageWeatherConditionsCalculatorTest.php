<?php

namespace App\Tests\Conditions;

use PHPUnit\Framework\TestCase;
use App\Conditions\WeatherConditions;
use App\Conditions\AverageWeatherConditionsCalculator;
use App\Conditions\WeatherType;

class AverageWeatherConditionsCalculatorTest extends TestCase
{
    /** @var AverageWeatherConditionsCalculator */
    private $AverageWeatherConditionsCalculator;

    public function testCalculateAverages()
    {
        $input = [
            $this->createWeatherConditions(5.2, 10.4, 15.1, 89.0, 2.0),
            $this->createWeatherConditions(5.4, 15.4, 25.1, 88, 3),
        ];

        $expected = $this->createWeatherConditions(5.3, 12.9, 20.1, 88.5, 2.5);

        $actual = $this->AverageWeatherConditionsCalculator->calculate($input);

        $this->assertEquals($expected->pm10, $actual->pm10);
        $this->assertEquals($expected->pm25, $actual->pm25);
        $this->assertEquals($expected->temperature, $actual->temperature);
        $this->assertEquals($expected->humidity, $actual->humidity);
        $this->assertEquals($expected->wind, $actual->wind);
    }

    public function testCalculateAveragesWithNullValues()
    {
        $input = [
            $this->createWeatherConditions(null, 10.4, 15.1, 89.0, 2.5),
            $this->createWeatherConditions(5.4, 15.4, null, 88, null),
        ];

        $expected = $this->createWeatherConditions(5.4, 12.9, 15.1, 88.5, 2.5);

        $actual = $this->AverageWeatherConditionsCalculator->calculate($input);

        $this->assertEquals($expected->pm10, $actual->pm10);
        $this->assertEquals($expected->pm25, $actual->pm25);
        $this->assertEquals($expected->temperature, $actual->temperature);
        $this->assertEquals($expected->humidity, $actual->humidity);
        $this->assertEquals($expected->wind, $actual->wind);
    }

    public function testCalculateAveragesWithWeatherType()
    {
        $input          = [
            $this->createWeatherConditions(null, 10.4, 15.1, 89.0, 2.5),
            $this->createWeatherConditions(5.4, 15.4, null, 88, null),
        ];
        $input[0]->type = new WeatherType(WeatherType::Drizzle);

        $expected       = $this->createWeatherConditions(5.4, 12.9, 15.1, 88.5, 2.5);
        $expected->type = new WeatherType(WeatherType::Drizzle);

        $actual = $this->AverageWeatherConditionsCalculator->calculate($input);

        $this->assertEquals($expected->pm10, $actual->pm10);
        $this->assertEquals($expected->pm25, $actual->pm25);
        $this->assertEquals($expected->temperature, $actual->temperature);
        $this->assertEquals($expected->humidity, $actual->humidity);
        $this->assertEquals($expected->wind, $actual->wind);
        $this->assertEquals($expected->type, $actual->type);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->AverageWeatherConditionsCalculator = new AverageWeatherConditionsCalculator;
    }

    private function createWeatherConditions($pm10, $pm25, $temp, $hum, $wind)
    {
        $conditions = new WeatherConditions;

        $conditions->pm10        = $pm10;
        $conditions->pm25        = $pm25;
        $conditions->temperature = $temp;
        $conditions->humidity    = $hum;
        $conditions->wind        = $wind;

        return $conditions;
    }

}
