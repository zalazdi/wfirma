<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Client;
use Zalazdi\wFirma\Collection;
use Zalazdi\wFirma\Query;

abstract class Repository
{
    protected $client;

    public $name;
    public $model;

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
        if (arrayGet($result['status']['code']) == 'OK') {
            return $this->assignToModel(arrayGet($result[$this->name]));
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

    /**
     * Fill models with response data
     *
     * @param array $result
     * @return array
     */
    protected function assignToModel(array $result = [])
    {
        $collection = new Collection();
        $collection->setParameters(arrayGet($result['parameters']));

        foreach($result as $key => $value) {
            if ($key != 'parameters') {
                $item = new $this->model($value);
                $collection->addItem($item);
            }
        }

        return $collection;
    }

    /**
     * @param string $function Function type
     *
     * @return Query
     */
    protected function newQuery($function)
    {
        return new Query($this->name, $function);
    }
}
