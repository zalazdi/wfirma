<?php

namespace Zalazdi\wFirma;

use Zalazdi\wFirma\Models\Model;

class Collection implements \IteratorAggregate, \ArrayAccess
{
    public $items;
    public $parameters;

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function toArray()
    {
        if (! is_array($this->items)) {
            return [];
        }

        return array_map(function($item) {
            return $item->toArray();
        }, $this->items);
    }

    /**
     * Set collection parameters
     *
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = (object)$parameters;
    }

    /**
     * Add item to collection
     *
     * @param object $item
     */
    public function addItem($item)
    {
        $this->items[] = $item;
    }

    /**
     * Get first item
     *
     * @return object
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * Get an iterator for the items
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}
