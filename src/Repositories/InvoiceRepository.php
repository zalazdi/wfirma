<?php

namespace Zalazdi\wFirma\Repositories;

use Zalazdi\wFirma\Models\Invoice;

class InvoiceRepository extends Repository
{
    public $name = 'invoices';
    public $singularName = 'invoice';
    public $model = Invoice::class;

    public function download($id, $parameters = [])
    {
        $query = $this->newQuery('download/'.$id);
        $query->addParameters([
            $this->name => [
                'parameters' => $parameters,
            ]
        ]);

        $result = $this->client->execute($query, false);

        return $result;
    }
}
