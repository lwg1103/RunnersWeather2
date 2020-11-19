<?php

namespace App\Domain\CurrentConditions;

use App\Domain\CurrentConditions\Exception\NoProvidersRegistered;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ConditionsChecker implements IConditionsChecker
{
    /** @var IConditionsProvider[] */
    private $ConditionsProviders = [];
    /** @var AdapterInterface */
    private $Cache;

    public function __construct(AdapterInterface $CachePool)
    {
        $this->Cache = $CachePool;
    }

    public function getCurrentConditionsForCoordinates(float $long, float $lat): array
    {
        $this->checkRegisteredProviders();
        $longRounded = round($long, 2);
        $latRounded  = round($lat, 2);
        $cacheKey    = sprintf("%f-%f", $longRounded, $latRounded);

        $CachedConditions = $this->Cache->getItem($cacheKey);

        if (!$CachedConditions->isHit())
        {
            $result = [];
            foreach ($this->ConditionsProviders as $ConditionsProvider)
            {
                $result[] = $ConditionsProvider->getCurrentConditionsForCoordinates(
                        $longRounded,
                        $latRounded
                );
            }
            $this->Cache->save($CachedConditions->set($result));

            return $result;
        }
        else
        {
            return $CachedConditions->get();
        }
    }

    public function registerConditionsProvider(IConditionsProvider $provider)
    {
        $this->ConditionsProviders[] = $provider;
    }

    private function checkRegisteredProviders()
    {
        if (count($this->ConditionsProviders) === 0)
        {
            throw new NoProvidersRegistered;
        }
    }

}
