<?php

use PHPUnit\Framework\TestCase;
use App\CurrentConditions\OpenWeatherConditionsProvider;
use App\HttpClient\IHttpClient;

class OpenWeatherConditionsProviderTest extends TestCase
{
    const APIResponse = "{\"coord\":{\"lon\":17.05,\"lat\":51.09},\"weather\":[{\"id\":803,\"main\":\"Clouds\",\"description\":\"broken clouds\",\"icon\":\"04n\"}],\"base\":\"stations\",\"main\":{\"temp\":275.09,\"feels_like\":269.42,\"temp_min\":272.59,\"temp_max\":277.59,\"pressure\":1028,\"humidity\":100},\"visibility\":10000,\"wind\":{\"speed\":5.7,\"deg\":320},\"clouds\":{\"all\":75},\"dt\":1577465801,\"sys\":{\"type\":1,\"id\":1715,\"country\":\"PL\",\"sunrise\":1577429703,\"sunset\":1577458201},\"timezone\":3600,\"id\":3081368,\"name\":\"Wroclaw\",\"cod\":200}";

    /** @var OpenWeatherConditionsProvider */
    private $OpenWeatherConditionsProvider;

    public function testGetCurrentConditionsReturnsResult()
    {
        
    }

    public function testGetCurrentConditionsReturnsWeatherConditions()
    {
        
    }

    public function testGetCurrentConditionsReturnsWeatherConditionsWithValues()
    {
        
    }

    protected function setUp()
    {
        parent::setUp();

        $HttpClientMock = $this->getMockBuilder(IHttpClient::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->OpenWeatherConditionsProvider = new OpenWeatherConditionsProvider($HttpClientMock);
    }

}
