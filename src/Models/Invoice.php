<?php

namespace Zalazdi\wFirma\Models;

use Zalazdi\wFirma\Collection;

class Invoice extends Model
{
    protected $casts = [
        'id'                    => 'int',
        'payment_method'        => 'string',
        'payment_date'          => 'datetime',
        'payment_status'        => 'string',
        'disposaldate_format'   => 'string',
        'disposaldate_empty'    => 'string',
        'disposaldate'          => 'string',
        'date'                  => 'string',
        'period'                => 'string',
        'total'                 => 'float',
        'total_composed'        => 'float',
        'alreadypaid'           => 'float',
        'alreadypaid_initial'   => 'float',
        'remaining'             => 'float',

        'number'                => 'int',
        'day'                   => 'int',
        'month'                 => 'int',
        'year'                  => 'int',
        'fullnumber'            => 'string',
        'semitemplatenumber'    => 'string',
        'type'                  => 'string',
        'correction_type'       => 'string',
        'corrections'           => 'int',

        'currency'              => 'string',
        'currency_exchange'     => 'float',
        'currency_label'        => 'string',
        'currency_date'         => 'string',
        'price_currency_exchange'               => 'float',
        'good_price_group_currency_exchange'    => 'float',
        'template'              => 'int',
        'auto_send'             => 'boolean',
        'description'           => 'string',
        'header'                => 'string',
        'footer'                => 'string',
        'user_name'             => 'user_name',
        'schema'                => 'string',
        'schema_bill'           => 'boolean',
        'schema_canceled'       => 'boolean',
        'register_description'  => 'string',
        'netto'                 => 'float',
        'tax'                   => 'float',
        'signed'                => 'boolean',
        'hash'                  => 'string',
        'id_external'           => 'string',
        'warehouse_type'        => 'boolean',
        'notes'                 => 'int',
        'documents'             => 'int',
        'tags'                  => 'string',
        'created'               => 'datetime',
        'modified'              => 'datetime',
        'price_type'            => 'string',

        'parent'                => Invoice::class,
        'order'                 => Invoice::class,

        'series'                => Series::class,
        'contractor'            => Contractor::class,
        'invoicecontents'       => Collection::class,
    ];
    public $readOnly = ['id', 'created', 'updated'];

    /** @const Faktura VAT */
    const TYPE_NORMAL = 'normal';
    /** @const Faktura pro forma */
    const TYPE_PROFORMA = 'proforma';
    /** @const Paragon niefiskalny */
    const TYPE_RECEIPT_NORMAL = 'receipt_normal';
    /** @const Paragon fiskalny */
    const TYPE_RECEIPT_FISCAL_NORMAL = 'receipt_fiscal_normal';
    /** @const Inny przychód - sprzedaż */
    const TYPE_INCOME_NORMAL = 'income_normal';

    /** @const Faktura (bez VAT) */
    const TYPE_BILL = 'bill';
    /** @const Faktura pro forma (bez VAT) */
    const TYPE_PROFORMA_BILL = 'proforma_bill';
    /** @const Paragon niefiskalny (bez VAT) */
    const TYPE_RECEIPT_BILL = 'receipt_normal';
    /** @const Paragon fiskalny (bez VAT) */
    const TYPE_RECEIPT_FISCAL_BILL = 'receipt_fiscal_normal';
    /** @const Inny przychód - sprzedaż (bez VAT) */
    const TYPE_INCOME_BILL = 'income_normal';

    /** @const Faktura korygująca */
    const TYPE_CORRECTION = 'correction';

    const PRICE_TYPE_NETTO              = 'netto';
    const PRICE_TYPE_BRUTTO             = 'brutto';

    const PAYMENT_METHOD_CASH           = 'cash';
    const PAYMENT_METHOD_TRANSFER       = 'transfer';
    const PAYMENT_METHOD_COMPENSATION   = 'compensation';
    const PAYMENT_METHOD_COD            = 'cod';
    const PAYMENT_METHOD_PAYMENT_CARD   = 'payment_card';

    const PAYMENT_STATE_PAID            = 'paid';
    const PAYMENT_STATE_UNPAID          = 'unpaid';
    const PAYMENT_STATE_UNDEFINED       = 'undefined';

    const DISPOSALDATE_FORMAT_MONTH     = 'month';
    const DISPOSALDATE_FORMAT_DAY       = 'day';

    const SCHEMA_NORMAL                 = 'normal';
    const SCHEMA_VAT_INVOICE_DATE       = 'vat_invoice_date';
    const SCHEMA_VAT_BUYER_CONSTRUCTION_STATE = 'vat_buyer_construction_service';
    const SCHEMA_ASSESSOR               = 'assessor';

    const WAREHOUSE_TYPE_SIMPLE         = 'simple';
    const WAREHOUSE_TYPE_EXTENDED       = 'extended';
}
