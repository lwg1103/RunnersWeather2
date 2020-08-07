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
    protected $responseMock;
    /** @var \App\Conditions\WeatherConditions */
    protected $result;

    public function testGetCurrentConditionsReturnsResult()
    {
        $this->givenResponseIsOk()
                ->whenGetConditions()
                ->thenResultIsNotNull();
    }

    public function testGetCurrentConditionsReturnsResultWithoutError()
    {
        $this->givenResponseIsOk()
                ->whenGetConditions()
                ->thenResultHasNoError();
    }

    public function testGetCurrentConditionsReturnsWeatherConditions()
    {
        $this->givenResponseIsOk()
                ->whenGetConditions()
                ->thenResultIsWeatherConditionsType();
    }

    public function testGetCurrentConditionsReturnsWeatherConditionsWithValues()
    {
        $this->givenResponseIsOk()
                ->whenGetConditions()
                ->thenResultHasValues();
    }

    public function testGetCurrentConditionsReturnsWeatherConditionsWithValuesFromResponse()
    {
        $this->givenResponseIsOk()
                ->whenGetConditions()
                ->thenResultHasResponseValues();
    }

    protected function givenResponseIsOk()
    {
        $this->responseMock = $this->getHttpResponseMock();

        return $this;
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

    protected function thenResultHasNoError()
    {
        $this->assertFalse($this->result->error);

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
                ->will($this->returnCallback(function()
                        {
                            return $this->responseMock;
                        }));

        $HttpClientMock->method('get')
                ->willReturn($responseMock);

        $this->ConditionsProvider = $this->createTestSubject($HttpClientMock);
    }

    abstract protected function thenResultHasValues();

    abstract protected function thenResultHasResponseValues();

    abstract protected function createTestSubject(IHttpClient $client): IConditionsProvider;

    abstract protected function getHttpResponseMock(): string;
}
