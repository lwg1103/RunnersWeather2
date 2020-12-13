<?php

namespace App\Infrastructure\Facebook;

use App\Application\Service\IAccessTokenVerificator;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;

class AccessTokenVerificator implements IAccessTokenVerificator
{

    /** @var Facebook */
    private $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function verify(string $token, string $email = null): bool
    {
        if (!isset($email))
        {
            return false;
        }
        
        try {
            $graphEmail = $this->facebook->get('/me?fields=email', "{$token}")->getGraphUser()['email'];
            
            return $email === $graphEmail;
        } catch (FacebookResponseException $ex) {
            return false;
        }
    }

}
