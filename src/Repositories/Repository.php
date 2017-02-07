<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Client;
use Zalazdi\wFirma\Collection;
use Zalazdi\wFirma\Models\Model;
use Zalazdi\wFirma\Query;

abstract class Repository
{
    protected $client;

    public $name;
    public $singularName;
    public $model;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($id)
    {
        $query = $this->newQuery('get/'.$id);

        $result = $this->client->execute($query);

        if (arrayGet($result['status']['code']) == 'OK') {
            return new $this->model(arrayGet($result[$this->name][0][$this->singularName]));
        }

        return false;
    }

    public function find($limit = 10, $page = 1, $conditions = [])
    {
        // @ToDo Add parameters

        $query = $this->newQuery('find');
        $query->addParameters([
            $this->name => [
                'parameters' => [
                    'limit' => $limit,
                    'page' => $page,
                    'conditions' => $conditions,
                ],
            ]
        ]);

        $result = $this->client->execute($query);

        if (arrayGet($result['status']['code']) == 'OK') {
            return $this->assignToModel(arrayGet($result[$this->name]));
        }
    }

    public function add(Model $model)
    {
        $query = $this->newQuery('add');
        $query->addParameters([
            $this->name => [
                $this->singularName => $model->toArray(),
            ]
        ]);

        $result = $this->client->execute($query);

        if (arrayGet($result['status']['code']) == 'OK') {
            return $model->fill(arrayGet($result[$this->name][0][$this->singularName]));
        }

        return false;
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
            if (is_int($key)) {
                $value = arrayGet($value[$this->singularName]);

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
