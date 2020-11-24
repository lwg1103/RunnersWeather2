<?php

namespace App\Infrastructure\ApiRequest;

use FOS\ElasticaBundle\Elastica\Client;

class ElasticStatsProvider implements IStatsProvider
{
       
    /** @var Client */
    private $ElasticaClient;
    
    public function __construct(Client $ElasticaClient)
    {
        $this->ElasticaClient = $ElasticaClient;
    }
    
    public function getCountByTime(): array
    {
        return $this->aggregateBy('hour', 24);
    }
    
    public function getCountByDecision(): array
    {
        return $this->aggregateBy('decision_type', 9);
    }
        
    private function aggregateBy(string $fieldName, int $size): array
    {
        $query = new \Elastica\Query();
        $agg = new \Elastica\Aggregation\Terms($fieldName);
        $agg->setField($fieldName);
        $agg->setSize($size);
        $query->addAggregation($agg);
        
        $findings = $this->ElasticaClient->getIndex('api_request_log')->search($query)->getAggregation($fieldName);
        
        $results = [];
        foreach ($findings['buckets'] as $bucket) {
            $results[$bucket['key']] = $bucket['doc_count'];
        }

        return $results;
    }

}
