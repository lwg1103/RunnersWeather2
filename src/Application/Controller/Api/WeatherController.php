<?php

namespace App\Application\Controller\Api;

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
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\HttpFoundation\Request;
use App\Application\Entity\User;
use App\Infrastructure\Repository\UserRepository;
use App\Application\Controller\InvalidApiTokenException;

/**
 * @Route("/weather")
 */
class WeatherController extends AbstractController
{

    /** @var IConditionsChecker */
    private $ConditionsChecker;

    /** @var IDecisionMaker */
    private $DecisionMaker;

    /** @var AverageWeatherConditionsCalculator */
    private $AverageWeatherConditionsCalculator;

    /** @var IHttpClient */
    private $HttpClient;

    /** @var IApiCallLogger */
    private $Logger;

    /** @var UserRepository */
    private $UserRepository;

    public function __construct(
            IConditionsChecker $ConditionsChecker,
            IDecisionMaker $DecisionMaker,
            AverageWeatherConditionsCalculator $AverageWeatherConditionsCalculator,
            IHttpClient $HttpClient,
            IApiCallLogger $Logger,
            UserRepository $UserRepository
    )
    {
        $this->ConditionsChecker = $ConditionsChecker;
        $this->DecisionMaker = $DecisionMaker;
        $this->AverageWeatherConditionsCalculator = $AverageWeatherConditionsCalculator;
        $this->HttpClient = $HttpClient;
        $this->Logger = $Logger;
        $this->UserRepository = $UserRepository;
    }

    /**
     * @Route("/", name="get_weather")
     * @param float $lat
     * @param float $long
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getWeather(Request $request)
    {
        try
        {
            list($token, $lat, $long) = $this->validateParameters($request);
            $User = $this->validateApiToken($token);

            $ApiCallLog = $this->Logger->log($lat, $long, $User);

            $this->ConditionsChecker->registerConditionsProvider(
                    new AirlyConditionsProvider($this->HttpClient, $this->getParameter('api.airly'))
            );

            $this->ConditionsChecker->registerConditionsProvider(
                    new OpenWeatherConditionsProvider($this->HttpClient, $this->getParameter('api.openweather'))
            );

            $conditions = $this->ConditionsChecker->getCurrentConditionsForCoordinates($long, $lat);

            $weather           = $this->AverageWeatherConditionsCalculator->calculate($conditions);
            $weather->decision = $this->DecisionMaker->checkWeatherForRunning($weather);

            $this->Logger->logDecision($ApiCallLog, $weather->decision);

            return $this->createJsonResponse($weather);
        }
        catch (InvalidParameterException $e)
        {
            return $this->createJsonResponse(null, 'invalid parameters');
        }
        catch (InvalidApiTokenException $e)
        {
            return $this->createJsonResponse(null, 'invalid api token');
        }
    }

    private function createJsonResponse($weather, string $error = ''): JsonResponse
    {
        $responseArray = [
            'error'   => $error,
            'weather' => $weather,
        ];

        $response = new JsonResponse($responseArray);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    private function validateParameters(Request $request): array
    {
        $parameters = json_decode($request->getContent(), true);

        if (isset($parameters['token']) && isset($parameters['lat']) && isset($parameters['long']))
        {
            return [$parameters['token'], $parameters['lat'], $parameters['long']];
        } else
        {
            throw new InvalidParameterException();
        }
    }
    
    private function validateApiToken(string $token): User
    {
        $User = $this->UserRepository->findByApiToken($token);
        
        if (is_null($User)) {
            throw new InvalidApiTokenException();
        }
        
        return $User;
    }

}
