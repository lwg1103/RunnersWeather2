<?php

namespace App\Tests\CurrentConditions;

use PHPUnit\Framework\TestCase;
use App\Conditions\WeatherConditions;

abstract class ConditionsProviderBase extends TestCase
{
    /** @var App\CurrentConditions\IConditionsProvider */
    protected $ConditionsProvider;
    protected $result;

    public function testGetCurrentConditionsReturnsResult()
    {
        $this->whenGetConditions()
                ->thenResultIsNotNull();
    }

    public function testGetCurrentConditionsReturnsWeatherConditions()
    {
        $this->whenGetConditions()
                ->thenResultIsWeatherConditionsType();
    }

    public function testGetCurrentConditionsReturnsWeatherConditionsWithValues()
    {
        $this->whenGetConditions()
                ->thenResultHasValues();
    }

    public function testGetCurrentConditionsReturnsWeatherConditionsWithValuesFromResponse()
    {
        $this->whenGetConditions()
                ->thenResultHasResponseValues();
    }

    protected function whenGetConditions()
    {
        $this->result = $this->ConditionsProvider->getCurrentConditionsForCoordinates(1.0, 1.0);

        return $this;
    }

    protected function thenResultIsNotNull()
    {
        $this->assertNotNull($this->result);

        return $this;
    }

    protected function thenResultIsWeatherConditionsType()
    {
        $this->assertInstanceOf(WeatherConditions::class, $this->result);

        return $this;
    }

    abstract protected function thenResultHasValues();

    abstract protected function thenResultHasResponseValues();
}
