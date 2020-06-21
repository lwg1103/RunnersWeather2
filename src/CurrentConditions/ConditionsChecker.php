<?php

namespace App\CurrentConditions;
use App\CurrentConditions\Exception\NoProvidersRegistered;

class ConditionsChecker implements IConditionsChecker
{
    /** @var IConditionsProvider[] */
    private $ConditionsProviders = [];
    
    public function getCurrentConditionsForCoordinates(float $long, float $lat): array
    {
        $this->checkRegisteredProviders();
        
        $result = [];
        
        foreach ($this->ConditionsProviders as $ConditionsProvider) {
            $result[] = $ConditionsProvider->getCurrentConditionsForCoordinates($long, $lat);
        }
        
        return $result;
    }

    public function registerConditionsProvider(IConditionsProvider $provider)
    {
        $this->ConditionsProviders[] = $provider;
    }
    
    private function checkRegisteredProviders()
    {
        if (count($this->ConditionsProviders) === 0) {
            throw new NoProvidersRegistered;
        }
    }

}
