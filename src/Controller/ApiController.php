<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


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
    public function getWeather(float $lat, float $long)
    {
        //TODO this is a mock controller, only for development phase
        $weather = [
            'pm10' => 10.1,
            'pm25' => 25.2,
            'temperature' => 22.23,
            'humidity' => 45.67,
            'wind' => 12.34,
            'type' => 'Clouds',
            'recommendation' => $lat,
        ];
        
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($weather));
        
        return $response;
    }
}
