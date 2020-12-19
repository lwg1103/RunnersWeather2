<?php

namespace App\Application\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Application\Service\IAccessTokenVerificator;
use App\Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use App\Application\Service\AuthTokenData;

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
        $tokenData = $this->validateParameters($request);

        if (!$this->TokenVerificator->verify($tokenData))
        {
            return $this->createJsonResponse(['verified' => false]);
        }
        
        $user = $this->getUserByEmail($tokenData->email);

        if (!$user->hasApiAccess()) {
            $user->grantApiAccess();
        }

        $this->EntityManager->flush();

        return $this->createJsonResponse(['verified' => true, 'token' => $user->getApiToken()]);
    }
    
    private function validateParameters(Request $request): AuthTokenData
    {
        $parameters = json_decode($request->getContent(), true);
        
        if (isset($parameters['token']) && isset($parameters['email'])) {
            return new AuthTokenData($parameters['email'], $parameters['token']);
        } else {
            throw new InvalidParameterException();
        }
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
    
    private function createJsonResponse($content): JsonResponse
    {
        $response = new JsonResponse($content);
        
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;
    }

}
