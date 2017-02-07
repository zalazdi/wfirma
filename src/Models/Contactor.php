<?php

namespace Zalazdi\wFirma\Models;

class Contactor extends Model
{
    public $casts = [
        'id'                => 'int',
        'name'              => 'string',
        'altname'           => 'string',
        'tax_id_type'       => 'string',
        'nip'               => 'int',
        'regon'             => 'int',
        'street'            => 'string',
        'zip'               => 'string',
        'city'              => 'string',
        'country'           => 'string',
        'different_contact_address' => 'boolean',
        'contact_name'      => 'string',
        'contact_street'    => 'string',
        'contact_zip'       => 'string',
        'contact_city'      => 'string',
        'contact_country'   => 'string',
        'contact_person'    => 'string',
        'phone'             => 'string',
        'skype'             => 'string',
        'fax'               => 'string',
        'email'             => 'string',
        'url'               => 'string',
        'description'       => 'string',
        'buyer'             => 'boolean',
        'seller'            => 'boolean',
        'account_number'    => 'int',
        'discount_percent'  => 'int',
        'payment_days'      => 'int',
        'payment_method'    => 'string',
        'remind'            => 'boolean',
        'hash'              => 'string',
        'notes'             => 'int',
        'documents'         => 'int',
        'tags'              => 'string',
        'created'           => 'date',
        'modified'          => 'date',
    ];

    const TAX_TYPE_NIP      = 'nip';
    const TAX_TYPE_VAT      = 'vat';
    const TAX_TYPE_PESEL    = 'pesel';
    const TAX_TYPE_REGON    = 'regon';
    const TAX_TYPE_CUSTOM   = 'custom';
    const TAX_TYPE_NONE     = 'none';
}
