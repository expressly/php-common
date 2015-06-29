<?php

namespace Expressly\Presenter;

class BatchCustomerPresenter implements PresenterInterface
{
    private $emails;

    public function __construct(Array $emails)
    {
        if (empty($emails['existing'])) {
            $emails['existing'] = array();
        }
        if (empty($emails['deleted'])) {
            $emails['deleted'] = array();
        }
        if (empty($emails['pending'])) {
            $emails['pending'] = array();
        }
        $this->emails = $emails;
    }

    public function toArray()
    {
        return array(
            'existing' => $this->emails['existing'],
            'deleted' => $this->emails['deleted'],
            'pending' => $this->emails['pending']
        );
    }
}