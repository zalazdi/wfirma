<?php

namespace Zalazdi\wFirma\Models;

class UserCompany extends Model
{
    protected $casts = [
        'id'            => 'int',
        'right'         => 'string',
        'company'       => Company::class,
    ];
}
