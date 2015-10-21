<?php

namespace Expressly\Provider;

use Expressly\Entity\Merchant;
use Silex\Application;

class MockMerchantProvider implements MerchantProviderInterface
{
    private $merchant;

    public function __construct()
    {
        $this->merchant = new Merchant();
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function setMerchant(Merchant $merchant)
    {
        if (!Merchant::compare($this->merchant, $merchant)) {
            $this->save($merchant);
        }

        return $this;
    }

    private function save(Merchant $merchant)
    {
        if (empty($this->merchant)) {
            return;
        }

        $this->merchant = $merchant;
    }
}