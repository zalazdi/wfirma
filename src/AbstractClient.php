<?php

namespace Zalazdi\wFirma;

abstract class AbstractClient
{
    abstract public function execute(Query $query, $json = true);

    abstract protected function parseConfig(array $config = []);
}
