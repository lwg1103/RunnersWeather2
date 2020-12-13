<?php

namespace App\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserApiAccess
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $apiKey;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $active = true;
    
    public function __construct(string $email)
    {
        $this->apiKey = md5($email. random_bytes(100));
    }
    
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function deactivate()
    {
        $this->active = false;
        
        return $this;
    }

    public function activate()
    {
        $this->active = true;
        
        return $this;
    }

}
