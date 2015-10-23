<?php

namespace Expressly\Presenter;

use Expressly\Entity\Invoice;
use Expressly\Entity\Merchant;

class BatchInvoicePresenter extends AbstractPresenter
{
    protected $public = false;

    public function __construct(Merchant $merchant, Array $invoices)
    {
        parent::__construct($merchant);

        foreach ($invoices as $invoice) {
            if ($invoice instanceof Invoice) {
                $this->data['invoices'][] = $invoice->toArray();
            }
        }
    }
}