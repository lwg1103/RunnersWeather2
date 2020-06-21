<?php

namespace App\CurrentConditions;

interface IConditionsChecker
{
    public function getCurrentConditionsForCoordinates(float $long, float $lat): array;
    
    public function registerConditionsProvider(IConditionsProvider $provider);
}
