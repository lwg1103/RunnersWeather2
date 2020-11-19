<?php

namespace App\Entity\ApiRequest;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="api_request_logs")
 */
class ApiRequestLog
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $user;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $DateTime;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $decisionType = 0;

    public function __construct(float $lat, float $long, int $user)
    {
        $this->longitude = $long;
        $this->latitude = $lat;
        $this->user = $user;
        $this->DateTime = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function getDateTime(): \DateTime
    {
        return $this->DateTime;
    }

    public function setDateTime(\DateTime $DateTime)
    {
        $this->DateTime = $DateTime;
        
        return $this;
    }

    public function getHour(): string
    {
        return $this->DateTime->format('H');
    }
    
    public function getDecisionType(): int
    {
        return $this->decisionType;
    }

    public function setDecisionType(int $decisionType)
    {
        $this->decisionType = $decisionType;
        
        return $this;
    }

}
