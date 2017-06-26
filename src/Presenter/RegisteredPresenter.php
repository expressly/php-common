<?php

namespace Expressly\Presenter;

class RegisteredPresenter implements PresenterInterface
{
    private $platformName = null;
    private $platformVersion = null;

    public function __construct($platformName = null, $platformVersion = null)
    {
        $this->platformName = $platformName;
        $this->platformVersion = $platformVersion;
    }

    public function toArray()
    {
        return array(
            'registered' => true,
            'lightbox' => 'javascript',
            'version' => 'V2',
            'platformName' => $this->platformName,
            'platformVersion' => $this->platformVersion
        );
    }
}