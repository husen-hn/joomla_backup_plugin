<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SymfonyDocs
{
    private $client;

    public function __construct()
    {
        $this->client = \Symfony\Component\HttpClient\HttpClient::create();
    }

    public function fetchGitHubInformation(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/users/husen-hn'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}
