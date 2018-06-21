<?php

namespace Zalazdi\wFirma;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class Client extends AbstractClient
{
    /**
     * @var string API Url
     */
    protected $url = 'https://api2.wfirma.pl/';

    /**
     * @var string API username
     */
    protected $username;

    /**
     * @var string API password
     */
    protected $password;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Client constructor.
     *
     * @param array $config API configuration
     */
    public function __construct(array $config = [])
    {
        $this->parseConfig($config);
        $this->initializeGuzzle();
    }

    public function execute(Query $query, $json = true)
    {
        $response = $this->guzzle->request(
            'POST',
            $query->path,
            ['json' => $query->parameters]
        );

        if ($json) {
            $body = json_decode($response->getBody()->getContents(), true);
        } else {
            $body = $response->getBody()->getContents();
        }

        return $body;
    }

    /**
     * Parse configuration
     *
     * @param array $config
     */
    protected function parseConfig(array $config = [])
    {
        $this->username         = arrayGet($config['username']);
        $this->password         = arrayGet($config['password']);
    }

    protected function initializeGuzzle()
    {
        $this->guzzle = new \GuzzleHttp\Client([
            'base_uri'  => $this->url,
            'auth'      => [$this->username, $this->password],
        ]);
    }
}
