<?php

namespace Expressly\Presenter;

use Expressly\Entity\Invoice;

class BatchInvoicePresenter implements PresenterInterface
{
    private $invoices = array();

    public function __construct(Array $invoices)
    {
        foreach ($invoices as $invoice) {
            if ($invoice instanceof Invoice) {
                $this->invoices[] = $invoice->toArray();
            }
        }
    }

    public function toArray()
    {
        return array(
            'invoices' => $this->invoices
        );
    }
}