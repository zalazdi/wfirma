<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Models\Contractor;

class ContractorRepository extends Repository
{
    public $name = 'contractors';
    public $singularName = 'contractor';
    public $model = Contractor::class;
}
