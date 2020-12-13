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

        if ($this->TokenVerificator->verify($token, $email))
        {
            /** @var $user User */
            $user = $this->EntityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (is_null($user))
            {
                $user = new User($email);
                $this->EntityManager->persist($user);
            }

            $user->grantApiAccess('abc', 'salt');

            $this->EntityManager->flush();

            return new JsonResponse(['verified' => true, 'token' => $user->getApiToken()]);
        }

        return new JsonResponse(['verified' => false]);
    }

}
