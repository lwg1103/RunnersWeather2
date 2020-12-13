<?php

namespace App\Application\Service;

interface IAccessTokenVerificator
{
    public function verify(string $token, string $email = null): bool;
}
