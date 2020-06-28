<?php

namespace App\Tests\CurrentConditions;

use PHPUnit\Framework\TestCase;
use App\Conditions\WeatherConditions;
use App\HttpClient\IHttpClient;
use App\CurrentConditions\IConditionsProvider;

abstract class ConditionsProviderBase extends TestCase
{
    /** @var IConditionsProvider */
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

    protected function setUp()
    {
        parent::setUp();

        $HttpClientMock = $this->getMockBuilder(IHttpClient::class)
                ->disableOriginalConstructor()
                ->getMock();

        $responseMock = $this->getMockBuilder(Symfony\Contracts\HttpClient\ResponseInterface::class)
                ->disableOriginalConstructor()
                ->setMethods(['getContent'])
                ->getMock();

        $responseMock->method('getContent')
                ->willReturn($this->getHttpResponseMock());

        $HttpClientMock->method('get')
                ->willReturn($responseMock);

        $this->ConditionsProvider = $this->createTestSubject($HttpClientMock);
    }

    abstract protected function thenResultHasValues();

    abstract protected function thenResultHasResponseValues();

    abstract protected function createTestSubject(IHttpClient $client): IConditionsProvider;

    abstract protected function getHttpResponseMock(): string;
}
