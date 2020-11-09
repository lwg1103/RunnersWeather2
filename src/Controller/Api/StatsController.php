<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/stats")
 */
class StatsController extends AbstractController
{    
    /**
     * @Route("/api-request/group/time", name="requests_by_time")
     */
    public function getApiRequestByTime()
    {
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode([
            0 => 0,
            1 => 0,
            2 => 2,
            3 => 4,
            5 => 8,
            6 => 5,
            7 => 1,
            8 => 0,
            9 => 0
        ]));

        return $response;
    }
    
    /**
     * @Route("/api-request/group/decision", name="requests_by_decision")
     */
    public function getApiRequestByDecision()
    {
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode([
            'ok' => 15,
            'low smog' => 2,
            'high smog' => 2,
            'rain' => 4,
            'too hot' => 0
        ]));

        return $response; 
    }
}
