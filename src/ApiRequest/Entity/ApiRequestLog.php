<?php

namespace ApiRequest\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

/** @ORM\Entity */
class ApiRequestLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $long;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $lat;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $user;

}
