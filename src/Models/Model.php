<?php

namespace Zalazdi\wFirma\Models;

use Zalazdi\wFirma\Collection;

class Model
{
    protected $casts = [];
    public $readOnly = [];

    public $attributes = [];

    public function __construct(array $parameters = [])
    {
        $this->fill($parameters);
    }

    /**
     * Fill model with data
     *
     * @param array $attributes
     */
    public function fill(array $attributes = [])
    {
        foreach ($this->casts as $key => $type) {
            $value = arrayGet($attributes[$key]);

            $this->setAttribute(
                $key,
                $value,
                $type
            );
        }
    }

    public function __get($key)
    {
        return arrayGet($this->attributes[$key]);
    }

    public function __set($key, $value)
    {
        $type = arrayGet($this->casts[$key]);

        $this->setAttribute($key, $value, $type);
    }

    public function setAttribute($key, $value, $type)
    {
        $this->attributes[$key] = $this->castAtribute($type, $value);
    }

    public function toArray()
    {
        $response = [];
        foreach ($this->attributes as $key => $value) {
            if ($value instanceof Model) {
                $response[$key] = $value->toArray();
            } elseif ($value instanceof Collection) {
                $values = [];
                foreach($value as $item) {
                    $values[] = [
                        (new \ReflectionClass($item))->getShortName() => $item->toArray()
                    ];
                }
                $response[$key] = $values;
            } elseif ($value !== null) {
                $response[$key] = $value;
            }
        }

        return $response;
    }

    protected function castAtribute($type, $value)
    {
        if ($value === null) {
            return $value;
        }

        if (is_subclass_of($type, Model::class)) {
            return new $type($value);
        }

        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return json_decode($value);
            case 'array':
            case 'json':
                return json_decode($value, true);
            case 'datetime':
                return new \DateTime($value);
            default:
                return $value;
        }
    }
}
