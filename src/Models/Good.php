<?php

namespace Zalazdi\wFirma\Models;

class Good extends Model
{
    protected $casts = [
        'id'                => 'int',
        'name'              => 'string',
        'code'              => 'string',
        'unit'              => 'string',
        'netto'             => 'float',
        'brutto'            => 'float',
        'lumpcode'          => 'int',
        'type'              => 'string',
        'classification'    => 'string',
        'discount'          => 'int',
        'description'       => 'string',
        'notes'             => 'int',
        'documents'         => 'int',
        'tags'              => 'string',
        'created'           => 'date',
        'modified'          => 'date',
        'count'             => 'int',
        'reserved'          => 'int',
        'min'               => 'int',
        'max'               => 'int',
        'secure'            => 'int',
        'visibility'        => 'boolean',
        'warehouse_type'    => 'string',
        'extended'          => 'string',
        'price_type'        => 'string',
        'vat'               => 'int',
    ];

    const TYPE_GOOD     = 'good';
    const TYPE_SERVICE  = 'service';

    const WAREHOUSE_TYPE_SIMPLE     = 'simple';
    const WAREHOUSE_TYPE_EXTENDED   = 'extended';

    const PRICE_TYPE_NETTO  = 'netto';
    const PRICE_TYPE_BRUTTO = 'brutto';
}
