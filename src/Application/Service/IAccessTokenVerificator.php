<?php

namespace App\Application\Service;

interface IAccessTokenVerificator
{
    public function verify(AuthTokenData $data): bool;
}
