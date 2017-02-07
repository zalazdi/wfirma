<?php

namespace Zalazdi\wFirma\Models;

use Zalazdi\wFirma\Repositories\SeriesRepository;

class Series extends Model
{
    public $casts = [
        'id'            => 'int',
        'name'          => 'string',
        'template'      => 'string',
        'initnumber'    => 'int',
        'type'          => 'string',
        'reset'         => 'string',
        'created'       => 'datetime',
        'modified'      => 'datetime',
    ];
    public $readOnly = ['id', 'created', 'updated'];

    const RESET_DAILY = 'daily';
    const RESET_MONTHY = 'monthly';
    const RESET_YEARLY = 'yearly';

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
}
