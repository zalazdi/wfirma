<?php

namespace Zalazdi\wFirma\Models;

class Model
{
    public $casts = [];
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
        foreach($this->casts as $key => $type) {
            $value = arrayGet($attributes[$key]);

            $this->setAttribute(
                $key,
                $value,
                $type
            );
        }
    }

    public function setAttribute($key, $value, $type)
    {
        $this->attributes[$key] = $this->castAtribute($type, $value);
    }

    protected function castAtribute($type, $value)
    {
        if ($value == null) {
            return $value;
        }

        switch ($type)
        {
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
                var_dump($value);
                return new \DateTime($value);
            default:
                return $value;
        }

    }
}
