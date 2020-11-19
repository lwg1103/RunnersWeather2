<?php

namespace App\Infrastructure\Logger;

use App\Entity\ApiRequest\ApiRequestLog;
use App\Domain\Decision\DecisionType;

interface IApiCallLogger 
{
    public function log(float $lat, float $long): ApiRequestLog;
    
    public function logDecision(ApiRequestLog $Log, DecisionType $Decision): ApiRequestLog;
}
