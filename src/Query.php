<?php

namespace Zalazdi\wFirma;

class Query
{
    /**
     * @var string URL
     */
    public $path;
    public $parameters = [];

    /**
     * Query constructor.
     *
     * @param string $module Module name
     * @param string $function Function name
     */
    public function __construct($module, $function)
    {
        $this->path = $module.'/'.$function.'?inputFormat=json&outputFormat=json';
    }

    /**
     * Add parameters
     *
     * @param array $parameters Parameters array as name => value
     */
    public function addParameters($parameters = [])
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * Add parameter
     *
     * @param string $name Parameter name
     * @param string $value Parameter value
     */
    public function addParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }
}
