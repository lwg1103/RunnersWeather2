<?php

namespace App\HttpClient;

use Symfony\Component\HttpClient\HttpClient as SymfonyHttpClient;

class HttpClient implements IHttpClient
{
    /** @var SymfonyHttpClient */
    private $SymfonyHttpClient;
    /** @var array */
    private $options = [];

    public function __construct()
    {
        $this->SymfonyHttpClient = SymfonyHttpClient::create();
    }

    public function get(string $url)
    {
        if ($this->options !== [])
        {
            return $this->SymfonyHttpClient->request('GET', $url, $this->options);
        }
        else
        {
            return $this->SymfonyHttpClient->request('GET', $url);
        }
    }

    public function setApiKey(string $key)
    {
        $this->options['headers']['apikey'] = $key;
    }

}
