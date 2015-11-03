<?php

namespace Expressly\Presenter;

class RegisteredPresenter implements PresenterInterface
{
    public function toArray()
    {
        return array(
            'registered' => true
        );
    }
}