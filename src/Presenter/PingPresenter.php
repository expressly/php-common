<?php

namespace Expressly\Presenter;

class PingPresenter
{
    public function toArray()
    {
        return array(
            'expressly' => 'Stuff is happening!'
        );
    }
}