<?php

namespace Zalazdi\wFirma\Models;

class Company extends Model
{
    protected $casts = [
        'id'                        => 'int',
        'name'                      => 'string',
        'altname'                   => 'string',
        'nip'                       => 'int',
        'vat_payer'                 => 'boolean',
        'tax'                       => 'string',
        'is_verified'               => 'boolean',
        'is_registered'             => 'boolean',
        'is_authorized'             => 'boolean',
        'edeclarations_verified'    => 'boolean',
    ];

    const TAX_TYPE_KPIR             = 'taxregister';
    const TAX_TYPE_LUMPSUM          = 'lumpregister';
}
