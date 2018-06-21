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
    public $errors;

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
            $model->fill(arrayGet($result[$this->name][0][$this->singularName]));
            return true;
        } else {
            $this->saveErrors($result[$this->name][0][$this->singularName]['errors']);
            return false;
        }
    }

    public function edit(Model $model, $id)
    {
        $query = $this->newQuery('edit/'.$id);
        $query->addParameters([
            $this->name => [
                $this->singularName => $model->toArray(),
            ]
        ]);

        $result = $this->client->execute($query);

        if (arrayGet($result['status']['code']) == 'OK') {
            $model->fill(arrayGet($result[$this->name][0][$this->singularName]));
            return true;
        } else {
            $this->saveErrors($result[$this->name][0][$this->singularName]['errors']);
            return false;
        }

        return false;
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
     * Tranform errors collection into assocciate colletion where key is a field name (like Laravel Validation)
     *
     * @param array $errors
     */
    protected function saveErrors($errors)
    {
        $collection = [];

        foreach ($errors as $error) {
            $newError = $error['error'];
            unset($newError['field']);
            $collection[$error['error']['field']][] = $newError;
        }
        $this->errors = collect($collection);
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
