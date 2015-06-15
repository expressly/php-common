<?php

namespace Expressly\Presenter;

use Expressly\Entity\Invoice;

class BatchOrderPresenter implements PresenterInterface
{
    private $invoices;

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
            'orders' => $this->invoices
        );
    }
}