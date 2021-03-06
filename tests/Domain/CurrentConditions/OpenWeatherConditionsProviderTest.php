<?php

namespace App\Tests\Domain\CurrentConditions;

use App\Domain\CurrentConditions\OpenWeatherConditionsProvider;
use App\HttpClient\IHttpClient;
use App\Domain\Conditions\WeatherConditions;
use App\Domain\Conditions\WeatherType;
use App\Domain\CurrentConditions\IConditionsProvider;

class OpenWeatherConditionsProviderTest extends ConditionsProviderBase
{
    const APIResponse = "{\"coord\":{\"lon\":17.05,\"lat\":51.09},\"weather\":[{\"id\":803,\"main\":\"Clouds\",\"description\":\"broken clouds\",\"icon\":\"04n\"}],\"base\":\"stations\",\"main\":{\"temp\":275.09,\"feels_like\":269.42,\"temp_min\":272.59,\"temp_max\":277.59,\"pressure\":1028,\"humidity\":100},\"visibility\":10000,\"wind\":{\"speed\":5.7,\"deg\":320},\"clouds\":{\"all\":75},\"dt\":1577465801,\"sys\":{\"type\":1,\"id\":1715,\"country\":\"PL\",\"sunrise\":1577429703,\"sunset\":1577458201},\"timezone\":3600,\"id\":3081368,\"name\":\"Wroclaw\",\"cod\":200}";
    
    protected function createTestSubject(IHttpClient $client): IConditionsProvider
    {
        return new OpenWeatherConditionsProvider($client, 'key');
    }

    protected function getHttpResponseMock(): string
    {
        return self::APIResponse;
    }

    protected function thenResultHasValues()
    {
        $emptyWeatherConditions = new WeatherConditions;

        $this->assertNotEquals($emptyWeatherConditions->humidity, $this->result->humidity);
        $this->assertNotEquals($emptyWeatherConditions->temperature, $this->result->temperature);
        $this->assertNotEquals($emptyWeatherConditions->wind, $this->result->wind);
        $this->assertNotEquals($emptyWeatherConditions->type, $this->result->type);
    }

    protected function thenResultHasResponseValues()
    {
        $this->assertEquals(100, $this->result->humidity);
        $this->assertEquals((int) (269.42 - 272.15), $this->result->temperature);
        $this->assertEquals(5.7, $this->result->wind);
        $this->assertEquals(new WeatherType(WeatherType::Clouds), $this->result->type);
    }

}
