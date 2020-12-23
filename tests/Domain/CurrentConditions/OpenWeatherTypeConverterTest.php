<?php

namespace App\Tests\Domain\CurrentConditions;

use PHPUnit\Framework\TestCase;
use App\Domain\CurrentConditions\OpenWeatherTypeConverter;
use App\Domain\Conditions\WeatherType;

class OpenWeatherTypeConverterTest extends TestCase
{
    /** @var OpenWeatherTypeConverter */
    private $Converter;

    /**
     * @dataProvider dataProvider
     */
    public function testConvertFromProviderFormatReturnsProperValue($sourceCode, $expectedCode)
    {
        $expected = new WeatherType($expectedCode);
        $actual   = $this->Converter->convertFromProviderFormat($sourceCode);

        $this->assertEquals($expected, $actual);
    }

    public function dataProvider()
    {
        return [
            [200, WeatherType::Thunderstorm],
            [201, WeatherType::Thunderstorm],
            [202, WeatherType::Thunderstorm],
            [210, WeatherType::Thunderstorm],
            [211, WeatherType::Thunderstorm],
            [212, WeatherType::Thunderstorm],
            [221, WeatherType::Thunderstorm],
            [230, WeatherType::Thunderstorm],
            [231, WeatherType::Thunderstorm],
            [223, WeatherType::Thunderstorm],
            [300, WeatherType::Drizzle],
            [301, WeatherType::Drizzle],
            [302, WeatherType::Drizzle],
            [310, WeatherType::Drizzle],
            [311, WeatherType::Drizzle],
            [312, WeatherType::Drizzle],
            [313, WeatherType::Drizzle],
            [314, WeatherType::Drizzle],
            [321, WeatherType::Drizzle],
            [500, WeatherType::Rain],
            [501, WeatherType::Rain],
            [502, WeatherType::Rain],
            [503, WeatherType::Rain],
            [504, WeatherType::Rain],
            [511, WeatherType::Rain],
            [520, WeatherType::Rain],
            [521, WeatherType::Rain],
            [522, WeatherType::Rain],
            [531, WeatherType::Rain],
            [600, WeatherType::Snow],
            [601, WeatherType::Snow],
            [602, WeatherType::Snow],
            [611, WeatherType::Snow],
            [612, WeatherType::Snow],
            [613, WeatherType::Snow],
            [615, WeatherType::Snow],
            [616, WeatherType::Snow],
            [620, WeatherType::Snow],
            [621, WeatherType::Snow],
            [622, WeatherType::Snow],
            [700, WeatherType::Other],
            [711, WeatherType::Other],
            [721, WeatherType::Other],
            [731, WeatherType::Other],
            [741, WeatherType::Other],
            [751, WeatherType::Other],
            [761, WeatherType::Other],
            [762, WeatherType::Other],
            [771, WeatherType::Other],
            [781, WeatherType::Other],
            [800, WeatherType::Clear],
            [801, WeatherType::Clouds],
            [802, WeatherType::Clouds],
            [803, WeatherType::Clouds],
            [804, WeatherType::Clouds],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->Converter = new OpenWeatherTypeConverter;
    }

}
