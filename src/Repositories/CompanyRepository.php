<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Exceptions\NotSupportedException;
use Zalazdi\wFirma\Models\Company;
use Zalazdi\wFirma\Models\Model;

class CompanyRepository extends Repository
{
    public $name = 'companies';
    public $singularName = 'company';
    public $model = Company::class;

    public function find($limit = 10, $page = 1, $conditions = [])
    {
        return new NotSupportedException('Method find() is not supported for companies.');
    }

    public function add(Model $model)
    {
        return new NotSupportedException('Method add() is not supported for companies.');
    }

    public function edit()
    {
        return new NotSupportedException('Method edit() is not supported for companies.');
    }

    public function delete()
    {
        return new NotSupportedException('Method delete() is not supported for companies.');
    }
}
