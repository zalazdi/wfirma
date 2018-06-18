<?php

namespace Zalazdi\wFirma\Models;

class InvoiceContent extends Model
{
    protected $casts = [
        'id'                => 'int',
        'name'              => 'string',
        'classification'    => 'string',
        'unit'              => 'string',
        'count'             => 'int',
        'price'             => 'float',
        'discount'          => 'boolean',
        'discount_percent'  => 'int',
        'netto'             => 'float',
        'brutto'            => 'float',
        'vat'               => 'string',
        'lumpcode'          => 'int',
        'created'           => 'date',
        'modified'          => 'date',
    ];
}
