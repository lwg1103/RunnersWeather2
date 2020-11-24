<?php

namespace App\Application\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\ApiRequest\IStatsProvider;
use App\Domain\Decision\DecisionType;

/**
 * @Route("/stats")
 */
class StatsController extends AbstractController
{   
    /** @var IStatsProvider */
    private $StatsProvider;
    
    public function __construct(IStatsProvider $StatsProvider)
    {
        $this->StatsProvider = $StatsProvider;
    }
    
    /**
     * @Route("/api-request/group/time", name="requests_by_time")
     */
    public function getApiRequestByTime()
    {
        return new JsonResponse($this->StatsProvider->getCountByTime());
    }
    
    /**
     * @Route("/api-request/group/decision", name="requests_by_decision")
     */
    public function getApiRequestByDecision()
    {
        $aggregation = $this->StatsProvider->getCountByDecision();
        
        $result = [];
        foreach ($aggregation as $decisionId => $count) {
            $decisionName = (string)(new DecisionType($decisionId));
            $result[$decisionName] = $count;
        }
        
        return new JsonResponse($result);
    }
}
