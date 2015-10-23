<?php

namespace Expressly\Presenter;

use Expressly\Entity\Merchant;

abstract class AbstractPresenter implements PresenterInterface
{
    protected $public = true;
    protected $merchant;
    protected $data = array();

    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    public function toArray()
    {
        return $this->isAuthorized() ? $this->data : array();
    }

    public function isAuthorized()
    {
        if ($this->public) {
            return true;
        }

        if (!empty($_SERVER['PHP_AUTH_USER']) &&
            !empty($_SERVER['PHP_AUTH_PW']) &&
            $this->merchant->getUuid() === $_SERVER['PHP_AUTH_USER'] &&
            $this->merchant->getPassword() === $_SERVER['PHP_AUTH_PW']
        ) {
            return true;
        }

        header('HTTP/1.1 401 Unauthorized');

        return false;
    }
}