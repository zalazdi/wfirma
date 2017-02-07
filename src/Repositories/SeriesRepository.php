<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Models\Series;

class SeriesRepository extends Repository
{
    public $name = 'series';
    public $singularName = 'series';
    public $model = Series::class;
}
