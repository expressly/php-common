<?php

namespace Expressly\Presenter;

class PingPresenter implements PresenterInterface
{
    public function toArray()
    {
        return array(
            'expressly' => 'Stuff is happening!'
        );
    }
}