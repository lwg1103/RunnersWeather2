<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Conditions\WeatherConditions;
use App\Conditions\WeatherType;
use App\CurrentConditions\IConditionsChecker;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * 
     * @Route("/weather/{lat}/{long}", name="get_weather")
     * @param float $lat
     * @param float $long
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getWeather(float $lat, float $long, IConditionsChecker $ConditionsChecker)
    {
        //TODO this is a mock controller, only for development phase
        if ($long === 1.0) {
            $weather = new WeatherConditions;
            $weather->pm10 = 10.1;
            $weather->pm25 = 25.2;
            $weather->temperature = 22.23;
            $weather->humidity = 45.67;
            $weather->wind = 12.34;
            $weather->type = (string)(new WeatherType(WeatherType::Drizzle));
            $weather->recommendation = $lat;
        } else {
            $ConditionsChecker->getCurrentConditionsForCoordinates($long, $lat);
        }
        
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent($weather->toJSON());
        
        return $response;
    }
}
