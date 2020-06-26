<?php

namespace App\HttpClient;

use Symfony\Component\HttpClient\HttpClient as SymfonyHttpClient;

class HttpClient implements IHttpClient
{
    /** @var SymfonyHttpClient */
    private $SymfonyHttpClient;
    /** @var array */
    private $headers = [];

    public function __construct()
    {
        $this->SymfonyHttpClient = SymfonyHttpClient::create();
    }

    public function get(string $url)
    {
        if ($this->headers !== [])
        {
            return $this->SymfonyHttpClient->request('GET', $url, [$this->headers]);
        }
        else
        {
            return $this->SymfonyHttpClient->request('GET', $url);
        }
    }

    public function setApiKey(string $key)
    {
        $this->headers['apikey'] = $key;
    }

}
