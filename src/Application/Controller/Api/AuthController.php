<?php

namespace App\Application\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Application\Service\IAccessTokenVerificator;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    /** @var IAccessTokenVerificator */
    private $TokenVerificator;
    
    public function __construct(IAccessTokenVerificator $TokenVerificator)
    {
        $this->TokenVerificator = $TokenVerificator;
    }
    
    /**
     * @Route("/facebook", name="facebook_auth")
     */
    public function authFacebook(Request $request)
    {
        $email = $request->request->get('email');
        $token = $request->request->get('token');
        
        return new JsonResponse(['verified' => $this->TokenVerificator->verify($token, $email)]);
    }
}
