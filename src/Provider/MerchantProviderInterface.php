<?php

namespace Expressly\Provider;

use Expressly\Entity\Merchant;

interface MerchantProviderInterface
{
    public function setMerchant(Merchant $merchant);

    public function getMerchant();
}