<?php

namespace App\Infrastructure\Logger;

use Doctrine\ORM\EntityManagerInterface;
use App\Application\Entity\ApiRequestLog;
use App\Domain\Decision\DecisionType;

class DBApiCallLogger implements IApiCallLogger
{
    /** @var EntityManagerInterface */
    private $EntityManager;
    
    public function __construct(EntityManagerInterface $EntityManager) 
    {
        $this->EntityManager = $EntityManager;
    }

    public function log(float $lat, float $long): ApiRequestLog
    {
        $ApiLog = new ApiRequestLog($lat, $long, 0);
        $this->EntityManager->persist($ApiLog);
        $this->EntityManager->flush();   
        
        return $ApiLog;
    }
    
    public function logDecision(ApiRequestLog $Log, DecisionType $Decision): ApiRequestLog
    {
        $Log->setDecisionType($Decision->getValue());
        $this->EntityManager->flush();   
        
        return $Log;
    }

}
