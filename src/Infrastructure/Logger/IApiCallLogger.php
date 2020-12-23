<?php

namespace App\Infrastructure\Logger;

use App\Application\Entity\ApiRequestLog;
use App\Domain\Decision\DecisionType;
use App\Application\Entity\User;

interface IApiCallLogger 
{
    public function log(float $lat, float $long, User $user): ApiRequestLog;
    
    public function logDecision(ApiRequestLog $Log, DecisionType $Decision): ApiRequestLog;
}
