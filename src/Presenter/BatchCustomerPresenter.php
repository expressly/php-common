<?php

namespace Expressly\Presenter;

class BatchCustomerPresenter implements PresenterInterface
{
    private $emails = array();

    public function __construct(Array $existing = array(), Array $deleted = array(), Array $pending = array())
    {
        $this->emails = array(
            'existing' => $existing,
            'deleted' => $deleted,
            'pending' => $pending
        );
    }

    public function toArray()
    {
        return $this->emails;
    }
}