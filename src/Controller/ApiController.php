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
            'PM10' => 10.1,
            'PM25' => 25.2,
            'Temp' => 22.23,
            'Hum' => 45.67,
            'Wind' => 12.34,
            'Type' => 'Clouds',
            'Recommendation' => $lat,
        ];
        
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($weather));
        
        return $response;
    }
}
