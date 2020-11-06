<?php

namespace App\Logger;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ApiRequest\ApiRequestLog;

class DBApiCallLogger implements IApiCallLogger
{
    /** @var EntityManagerInterface */
    private $EntityManager;
    
    public function __construct(EntityManagerInterface $EntityManager) 
    {
        $this->EntityManager = $EntityManager;
    }

    public function log(float $lat, float $long) 
    {
        $ApiLog = new ApiRequestLog($lat, $long, 0);
        $this->EntityManager->persist($ApiLog);
        $this->EntityManager->flush();   
    }

}
