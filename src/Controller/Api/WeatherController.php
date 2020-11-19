<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\HttpClient\IHttpClient;
use App\Domain\CurrentConditions\IConditionsChecker;
use App\Domain\Conditions\AverageWeatherConditionsCalculator;
use App\Domain\Decision\IDecisionMaker;
use App\Domain\CurrentConditions\AirlyConditionsProvider;
use App\Domain\CurrentConditions\OpenWeatherConditionsProvider;
use App\Infrastructure\Logger\IApiCallLogger;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/weather")
 */
class WeatherController extends AbstractController
{

    /**
     * @Route("/{lat}/{long}", name="get_weather")
     * @param float $lat
     * @param float $long
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getWeather(
            float $lat,
            float $long,
            IConditionsChecker $ConditionsChecker,
            IDecisionMaker $DecisionMaker,
            AverageWeatherConditionsCalculator $AverageWeatherConditionsCalculator,
            IHttpClient $HttpClient,
            IApiCallLogger $Logger)
    {
        $ApiCallLog = $Logger->log($lat, $long);

        $ConditionsChecker->registerConditionsProvider(
                new AirlyConditionsProvider($HttpClient, $this->getParameter('api.airly'))
        );

        $ConditionsChecker->registerConditionsProvider(
                new OpenWeatherConditionsProvider($HttpClient, $this->getParameter('api.openweather'))
        );

        $conditions = $ConditionsChecker->getCurrentConditionsForCoordinates($long, $lat);

        $weather = $AverageWeatherConditionsCalculator->calculate($conditions);
        $weather->decision = $DecisionMaker->checkWeatherForRunning($weather);
        
        $Logger->logDecision($ApiCallLog, $weather->decision);

        return new JsonResponse($weather);
    }

}
