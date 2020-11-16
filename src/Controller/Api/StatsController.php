<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\ElasticaBundle\Elastica\Client;

/**
 * @Route("/stats")
 */
class StatsController extends AbstractController
{   
    /** @var Client */
    private $ElasticaClient;
    
    public function __construct(Client $ElasticaClient)
    {
        $this->ElasticaClient = $ElasticaClient;
    }
    
    /**
     * @Route("/api-request/group/time", name="requests_by_time")
     */
    public function getApiRequestByTime()
    {
        $query = new \Elastica\Query();
        $agg = new \Elastica\Aggregation\Terms('hours');
        $agg->setField('hour');
        $agg->setSize(10);
        $query->addAggregation($agg);
        
        $findings = $this->ElasticaClient->getIndex('api_request')->search($query)->getAggregation("hours");
        
        $results = [];
        foreach ($findings['buckets'] as $bucket) {
            $results[$bucket['key']] = $bucket['doc_count'];
        }

        return new JsonResponse($results);
    }
    
    /**
     * @Route("/api-request/group/decision", name="requests_by_decision")
     */
    public function getApiRequestByDecision()
    {
        return new JsonResponse([
            'ok' => 15,
            'low smog' => 2,
            'high smog' => 2,
            'rain' => 4,
            'too hot' => 0
        ]);; 
    }
}
