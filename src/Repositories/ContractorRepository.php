<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Models\Contactor;
class ContractorRepository extends Repository
{
    public $name = 'contractors';
    public $singularName = 'contractor';
    public $model = Contactor::class;
}
