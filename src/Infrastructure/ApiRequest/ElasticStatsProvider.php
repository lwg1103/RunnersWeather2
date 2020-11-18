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
        $query = new \Elastica\Query();
        $agg = new \Elastica\Aggregation\Terms('hours');
        $agg->setField('hour');
        $agg->setSize(24);
        $query->addAggregation($agg);
        
        $findings = $this->ElasticaClient->getIndex('api_request')->search($query)->getAggregation("hours");
        
        $results = [];
        foreach ($findings['buckets'] as $bucket) {
            $results[$bucket['key']] = $bucket['doc_count'];
        }

        return $results;
    }
    
    public function getCountByDecision(): array
    {
        return [
            'ok' => 15,
            'low smog' => 2,
            'high smog' => 2,
            'rain' => 4,
            'too hot' => 0
        ]; 
    }

}
