<?php

namespace Expressly\Presenter;

class BatchCustomerPresenter implements PresenterInterface
{
    private $emails;

    public function __construct(Array $emails)
    {
        $this->emails = $emails;
    }

    public function toArray()
    {
        return array(
            'emails' => $this->emails
        );
    }
}