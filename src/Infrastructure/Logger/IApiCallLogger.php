<?php

namespace App\Infrastructure\Logger;

use App\Application\Entity\ApiRequestLog;
use App\Domain\Decision\DecisionType;

interface IApiCallLogger 
{
    public function log(float $lat, float $long): ApiRequestLog;
    
    public function logDecision(ApiRequestLog $Log, DecisionType $Decision): ApiRequestLog;
}
