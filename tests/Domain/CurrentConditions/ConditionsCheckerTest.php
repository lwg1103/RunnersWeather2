<?php

namespace App\Tests\Domain\CurrentConditions;

use PHPUnit\Framework\TestCase;
use App\Domain\CurrentConditions\ConditionsChecker;
use App\Domain\CurrentConditions\Exception\NoProvidersRegistered;
use App\Domain\Conditions\WeatherConditions;
use App\Domain\CurrentConditions\IConditionsProvider;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ConditionsCheckerTest extends TestCase
{
    const LONG         = 12.345678;
    const LAT          = 56.789012;
    const LONG_ROUNDED = 12.35;
    const LAT_ROUNDED  = 56.79;

    /** @var ConditionsChecker */
    private $ConditionsChecker;
    /** @var AdapterInterface */
    private $CacheAdapterMock;
    /** @var ItemInterface */
    private $CacheItemMock;
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
                ->givenThereAreNoCachedConditions()
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
                ->givenThereAreNoCachedConditions()
                ->whenRunGetConditions()
                ->thenResultHasXConditions(2)
                ->thenResultContains($WeatherConditions1)
                ->thenResultContains($WeatherConditions2);
    }

    public function testReturnsCachedConditionsIfSet()
    {
        $WeatherConditions       = new WeatherConditions;
        $CachedWeatherConditions = new WeatherConditions;

        $this->givenProviderWasRegistered($WeatherConditions)
                ->givenThereAreCachedConditions($CachedWeatherConditions)
                ->whenRunGetConditions()
                ->thenResultHasXConditions(1)
                ->thenResultContains($CachedWeatherConditions);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->setUpCacheAdapterMock();

        $this->ConditionsChecker = new ConditionsChecker($this->CacheAdapterMock);
    }

    private function givenProviderWasRegistered(WeatherConditions $CurrentWeather)
    {
        $provider = $this->getMockBuilder(IConditionsProvider::class)
                ->disableOriginalConstructor()
                ->getMock();

        $provider->expects($this->any())
                ->method('getCurrentConditionsForCoordinates')
                ->with(self::LONG_ROUNDED, self::LAT_ROUNDED)
                ->willReturn($CurrentWeather);

        $this->ConditionsChecker->registerConditionsProvider($provider);

        return $this;
    }

    private function givenThereAreNoCachedConditions()
    {
        $this->CacheItemMock->method('isHit')
                ->willReturn(false);

        $this->CacheItemMock->method('set')
                ->willReturnSelf();

        return $this;
    }

    private function givenThereAreCachedConditions(WeatherConditions $CachedWeatherConditions)
    {
        $this->CacheItemMock->method('isHit')
                ->willReturn(true);

        $this->CacheItemMock->method('get')
                ->willReturn([$CachedWeatherConditions]);

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

    private function setUpCacheAdapterMock()
    {
        $this->CacheAdapterMock = $this->getMockBuilder(AdapterInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->CacheItemMock = $this->getMockBuilder(ItemInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->CacheAdapterMock->method('getItem')
                ->willReturn($this->CacheItemMock);
    }

}
