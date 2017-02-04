<?php

namespace Zalazdi\wFirma;

use function GuzzleHttp\json_decode;

class Client
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
     * @param string $username API username
     * @param string $password API password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

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

    protected function initializeGuzzle()
    {
        $this->guzzle = new \GuzzleHttp\Client([
            'base_uri'  => $this->url,
            'auth'      => [$this->username, $this->password],
        ]);
    }
}
