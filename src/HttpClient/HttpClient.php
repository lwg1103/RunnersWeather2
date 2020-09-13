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

    public function get(string $url, array $query)
    {
        $this->options['query'] = $query;

        return $this->SymfonyHttpClient->request('GET', $url, $this->options);
    }

    public function setApiKey(string $key)
    {
        $this->options['headers']['apikey'] = $key;
    }

}
