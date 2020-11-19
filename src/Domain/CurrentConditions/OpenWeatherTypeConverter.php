<?php

namespace App\Domain\CurrentConditions;

use App\Domain\Conditions\WeatherType;

class OpenWeatherTypeConverter
{

    public function convertFromProviderFormat($source): WeatherType
    {
        //https://openweathermap.org/weather-conditions

        if ($source < 300)
        {
            $code = WeatherType::Thunderstorm;
        }
        else if ($source < 400)
        {
            $code = WeatherType::Drizzle;
        }
        else if ($source < 600)
        {
            $code = WeatherType::Rain;
        }
        else if ($source < 700)
        {
            $code = WeatherType::Snow;
        }
        else if ($source == 800)
        {
            $code = WeatherType::Clear;
        }
        else if ($source > 800)
        {
            $code = WeatherType::Clouds;
        }
        else
        {
            $code = WeatherType::Other;
        }

        return new WeatherType($code);
    }

}
