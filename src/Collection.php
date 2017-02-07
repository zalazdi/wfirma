<?php

namespace Zalazdi\wFirma;

use Zalazdi\wFirma\Models\Model;

class Collection implements \IteratorAggregate
{
    public $items;
    public $parameters;

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
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
     * Get an iterator for the items
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
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
}
