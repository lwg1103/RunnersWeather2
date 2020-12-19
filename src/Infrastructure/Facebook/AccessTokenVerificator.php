<?php

namespace App\Infrastructure\Facebook;

use App\Application\Service\IAccessTokenVerificator;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use App\Application\Service\AuthTokenData;

class AccessTokenVerificator implements IAccessTokenVerificator
{

    /** @var Facebook */
    private $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function verify(AuthTokenData $data): bool
    {
        if (!isset($data->email))
        {
            return false;
        }
        
        try {
            $graphEmail = $this->facebook->get('/me?fields=email', "{$data->token}")->getGraphUser()['email'];
            
            return $data->email === $graphEmail;
        } catch (FacebookResponseException $ex) {
            return false;
        }
    }

}
