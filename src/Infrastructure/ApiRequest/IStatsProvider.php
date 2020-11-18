<?php

namespace App\Infrastructure\ApiRequest;

interface IStatsProvider
{
    public function getCountByTime(): array;
    
    public function getCountByDecision(): array;
}
