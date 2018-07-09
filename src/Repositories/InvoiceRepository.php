<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Models\Invoice;

class InvoiceRepository extends Repository
{
    public $name = 'invoices';
    public $singularName = 'invoice';
    public $model = Invoice::class;

    public function download($id, $companyId = null, $parameters = [])
    {
        $query = $this->newQuery('download/'.$id, $companyId);
        $query->addParameters([
            $this->name => [
                'parameters' => $parameters,
            ]
        ]);

        $result = $this->client->execute($query, false);

        return $result;
    }
}
