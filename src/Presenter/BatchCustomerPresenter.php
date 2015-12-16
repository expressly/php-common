<?php

namespace Expressly\Presenter;

class BatchCustomerPresenter implements PresenterInterface
{
    private $emails = array();

    public function __construct(array $existing = array(), array $deleted = array(), array $pending = array())
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