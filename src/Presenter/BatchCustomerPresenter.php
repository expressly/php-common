<?php

namespace Expressly\Presenter;

use Expressly\Entity\Merchant;

class BatchCustomerPresenter extends AbstractPresenter
{
    protected $public = false;

    public function __construct(Merchant $merchant, Array $emails)
    {
        parent::__construct($merchant);

        if (empty($emails['existing'])) {
            $emails['existing'] = array();
        }
        if (empty($emails['deleted'])) {
            $emails['deleted'] = array();
        }
        if (empty($emails['pending'])) {
            $emails['pending'] = array();
        }

        $this->data = $emails;
    }
}