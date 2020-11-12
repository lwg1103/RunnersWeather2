<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @Template
     */
    public function index()
    {
        return [];
    }
    
    /**
     * @Route("/stats", name="stats")
     * @Template("stats/index.html.twig")
     */
    public function stats()
    {
        return [];
    }
}
