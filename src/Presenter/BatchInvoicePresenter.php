<?php

namespace Expressly\Presenter;

use Expressly\Entity\Invoice;

class BatchInvoicePresenter implements PresenterInterface
{
    private $invoices = array();

    public function __construct(array $invoices)
    {
        foreach ($invoices as $invoice) {
            if ($invoice instanceof Invoice && $invoice->hasOrders()) {
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