<?php

namespace Zalazdi\wFirma;

use function GuzzleHttp\json_decode;

class Client
{
    const AUTH_BASIC = 1;
    const AUTH_OAUTH = 2;

    /**
     * @var string API Url
     */
    protected $url = 'https://api2.wfirma.pl/';

    /**
     * @var int Type of authentication
     */
    protected $authentication;

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

    public function execute(Query $query)
    {
        $response = $this->guzzle->request(
            'POST',
            $query->path,
            ['json' => $query->parameters]
        );

        $body = json_decode($response->getBody()->getContents(), true);

        return $body;
    }

    /**
     * Parse configuration
     *
     * @param array $config
     */
    protected function parseConfig(array $config = [])
    {
        $this->authentication   = arrayGet($config['authentication'], self::AUTH_BASIC);
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
