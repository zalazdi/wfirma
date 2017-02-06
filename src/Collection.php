<?php

namespace Zalazdi\wFirma;

class Collection implements \IteratorAggregate
{
    public $items;
    public $parameters;

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
}
