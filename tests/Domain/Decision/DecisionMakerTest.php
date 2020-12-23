<?php

namespace App\Tests\Domain\Decision;

use PHPUnit\Framework\TestCase;
use App\Domain\Decision\DecisionMaker;
use App\Domain\Conditions\WeatherType;
use App\Domain\Conditions\WeatherConditions;
use App\Domain\Decision\DecisionType;

class DecisionMakerTest extends TestCase
{
    /** @var DecisionMaker */
    private $DecisionMaker;

    public function testIsAGoodWeatherForRunningReturnsLowSmogIfPM25IsBetween26And50()
    {
        $conditions = $this->createWeatherConditions(25, 30, 15, 30);

        $expected = new DecisionType(DecisionType::LowSmog);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnsStringWindIfWindIsOver10()
    {
        $conditions = $this->createWeatherConditions(20, 10, 15, 30, 12);

        $expected = new DecisionType(DecisionType::StrongWind);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnsColdIfTemperatureIsLow()
    {
        $conditions = $this->createWeatherConditions(25, 15, -15, 30);

        $expected = new DecisionType(DecisionType::TooCold);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnsHotIfTemperatureAndHumidityAreHigh()
    {
        //40'C 35%
        $conditions = $this->createWeatherConditions(25, 15, 40, 35);

        $expected = new DecisionType(DecisionType::TooHot);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //32'C 90%
        $conditions = $this->createWeatherConditions(25, 15, 32, 90);

        $expected = new DecisionType(DecisionType::TooHot);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //36'C 60%
        $conditions = $this->createWeatherConditions(25, 15, 36, 60);

        $expected = new DecisionType(DecisionType::TooHot);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnOkIfTemperatureHumiditySmogAreOk()
    {
        //35'C 35%
        $conditions = $this->createWeatherConditions(25, 15, 35, 35);

        $expected = new DecisionType(DecisionType::OK);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //25'C 100%
        $conditions = $this->createWeatherConditions(25, 15, 25, 90);

        $expected = new DecisionType(DecisionType::OK);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //30'C 60%
        $conditions = $this->createWeatherConditions(25, 15, 30, 60);

        $expected = new DecisionType(DecisionType::OK);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnOkIfSkyIsClearOrCloudy()
    {
        //clear sky
        $conditions = $this->createWeatherConditions(25, 15, 35, 35, 0, WeatherType::Clear);

        $expected = new DecisionType(DecisionType::OK);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //cloudy
        $conditions = $this->createWeatherConditions(25, 15, 25, 90, 0, WeatherType::Clouds);

        $expected = new DecisionType(DecisionType::OK);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnRainIfTheresThunderRainSnow()
    {
        //clear sky
        $conditions = $this->createWeatherConditions(25, 15, 35, 35, 0, WeatherType::Rain);

        $expected = new DecisionType(DecisionType::Rain);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //cloudy
        $conditions = $this->createWeatherConditions(25, 15, 25, 90, 0, WeatherType::Snow);

        $expected = new DecisionType(DecisionType::Rain);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //cloudy
        $conditions = $this->createWeatherConditions(25, 15, 25, 90, 0, WeatherType::Thunderstorm);

        $expected = new DecisionType(DecisionType::Rain);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    public function testIsAGoodWeatherForRunningReturnBadWeatherIfTheresDrizzleOrFog()
    {
        //clear sky
        $conditions = $this->createWeatherConditions(25, 15, 35, 35, 0, WeatherType::Drizzle);

        $expected = new DecisionType(DecisionType::BadWeather);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);

        //cloudy
        $conditions = $this->createWeatherConditions(25, 15, 25, 90, 0, WeatherType::Other);

        $expected = new DecisionType(DecisionType::BadWeather);
        $actual   = $this->DecisionMaker->checkWeatherForRunning($conditions);

        $this->assertEquals($expected, $actual);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->DecisionMaker = new DecisionMaker;
    }

    private function createWeatherConditions(float $pm10, float $pm25, float $temp, float $hum, float $wind = 0, int $type = WeatherType::Clear)
    {
        $conditions = new WeatherConditions;

        $conditions->provider    = 'test';
        $conditions->pm10        = $pm10;
        $conditions->pm25        = $pm25;
        $conditions->humidity    = $hum;
        $conditions->temperature = $temp;
        $conditions->wind        = $wind;
        $conditions->type        = new WeatherType($type);

        return $conditions;
    }

}
