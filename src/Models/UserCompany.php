<?php

namespace Zalazdi\wFirma\Models;

class UserCompany extends Model
{
    public $casts = [
        'id'            => 'int',
        'right'         => 'string',
        'user'          => 'array',
        'warehouse'     => 'array',
        'company'       => 'array',
    ];
}
