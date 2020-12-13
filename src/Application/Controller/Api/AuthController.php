<?php

namespace App\Application\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Application\Service\IAccessTokenVerificator;
use App\Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    /** @var IAccessTokenVerificator */
    private $TokenVerificator;
    /** @var EntityManagerInterface */
    private $EntityManager;

    public function __construct(IAccessTokenVerificator $TokenVerificator, EntityManagerInterface $EntityManager)
    {
        $this->TokenVerificator = $TokenVerificator;
        $this->EntityManager    = $EntityManager;
    }

    /**
     * @Route("/facebook", name="facebook_auth")
     */
    public function authFacebook(Request $request)
    {
        $email = $request->request->get('email');
        $token = $request->request->get('token');

        if (!$this->TokenVerificator->verify($token, $email))
        {
            return new JsonResponse(['verified' => false]);
        }
        
        $user = $this->getUserByEmail($email);

        if (!$user->hasApiAccess()) {
            $user->grantApiAccess();
        }

        $this->EntityManager->flush();

        return new JsonResponse(['verified' => true, 'token' => $user->getApiToken()]);
    }
    
    private function getUserByEmail(string $email): User
    {
        $user = $this->EntityManager->getRepository(User::class)->findOneByEmail($email);
        
        if (is_null($user))
        {
            $user = new User($email);
            $this->EntityManager->persist($user);
        }
        
        return $user;
    }

}
