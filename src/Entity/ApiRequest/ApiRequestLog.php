<?php

namespace App\Entity\ApiRequest;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="api_request_logs")
 */
class ApiRequestLog {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $longitude;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $latitude;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $user;

    public function __construct(int $long, int $lat, int $user) {
        $this->longitude = $long;
        $this->latitude = $lat;
        $this->user = $user;
    }

    public function getId() {
        return $this->id;
    }

    public function getLongitude(): int {
        return $this->longitude;
    }

    public function getLatitude(): int {
        return $this->latitude;
    }

    public function getUser(): int {
        return $this->user;
    }

}
