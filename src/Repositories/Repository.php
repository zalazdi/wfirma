<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Client;
use Zalazdi\wFirma\Query;

abstract class Repository
{
    protected $client;

    public $name;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get()
    {

    }

    public function find($limit = 10, $page = 1, $parameters = false)
    {
        // @ToDo Add parameters

        $query = $this->newQuery('find');
        $query->addParameters([
            'limit' => $limit,
            'page' => $page
        ]);

        $result = $this->client->execute($query);

        // @ToDo Return collection instead of Array
        if (array_get($result, 'status.code') == 'OK') {
            return $result[$this->name];
        }
    }

    public function add()
    {

    }

    public function edit()
    {

    }

    public function delete()
    {

    }

    protected function newQuery($function)
    {
        return new Query($this->name, $function);
    }
}
