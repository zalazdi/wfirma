<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Models\UserCompany;

class UserCompanyRepository extends Repository
{
    public $name = 'user_companies';
    public $singularName = 'user_company';
    public $model = UserCompany::class;
}
