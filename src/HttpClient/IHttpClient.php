<?php

namespace App\HttpClient;

interface IHttpClient
{
    public function setApiKey(string $key);

    public function get(string $url, array $query);
}
