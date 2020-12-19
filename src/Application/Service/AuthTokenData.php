<?php

namespace App\Application\Service;

final class AuthTokenData
{
    public $email;
    
    public $token;
    
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
}
