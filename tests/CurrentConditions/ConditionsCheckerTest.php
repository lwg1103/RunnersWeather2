<?php

namespace App\Tests\CurrentConditions;

use PHPUnit\Framework\TestCase;
use App\CurrentConditions\ConditionsChecker;
use App\CurrentConditions\Exception\NoProvidersRegistered;
use App\Conditions\WeatherConditions;
use App\CurrentConditions\IConditionsProvider;

class ConditionsCheckerTest extends TestCase
{
    const LONG = 12.34;
    const LAT  = 56.78;

    /** @var ConditionsChecker */
    private $ConditionsChecker;
    private $result;

    public function testThrowsExceptionIfNoProvidersRegistered()
    {
        $this->expectException(NoProvidersRegistered::class);
        $this->whenRunGetConditions();
    }

    public function testReturnsConditionsFromProvider()
    {
        $WeatherConditions = new WeatherConditions;

        $this->givenProviderWasRegistered($WeatherConditions)
                ->whenRunGetConditions()
                ->thenResultHasXConditions(1)
                ->thenResultContains($WeatherConditions);
    }

    public function testReturnsConditionsFromEachProvider()
    {
        $WeatherConditions1 = new WeatherConditions;
        $WeatherConditions2 = new WeatherConditions;

        $this->givenProviderWasRegistered($WeatherConditions1)
                ->givenProviderWasRegistered($WeatherConditions2)
                ->whenRunGetConditions()
                ->thenResultHasXConditions(2)
                ->thenResultContains($WeatherConditions1)
                ->thenResultContains($WeatherConditions2);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->ConditionsChecker = new ConditionsChecker;
    }

    private function givenProviderWasRegistered(WeatherConditions $CurrentWeather)
    {
        $provider = $this->getMockBuilder(IConditionsProvider::class)
                ->disableOriginalConstructor()
                ->getMock();

        $provider->expects($this->once())
                ->method('getCurrentConditionsForCoordinates')
                ->with(self::LONG, self::LAT)
                ->willReturn($CurrentWeather);

        $this->ConditionsChecker->registerConditionsProvider($provider);

        return $this;
    }

    private function whenRunGetConditions()
    {
        $this->result = $this->ConditionsChecker
                ->getCurrentConditionsForCoordinates(self::LONG, self::LAT);

        return $this;
    }

    private function thenResultHasXConditions(int $x)
    {
        $this->assertCount($x, $this->result);

        return $this;
    }

    private function thenResultContains(WeatherConditions $WeatherConditions)
    {
        $this->assertContains($WeatherConditions, $this->result);

        return $this;
    }

}
