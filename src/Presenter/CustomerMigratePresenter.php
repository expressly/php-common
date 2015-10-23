<?php

namespace Expressly\Presenter;

use Expressly\Entity\Customer;
use Expressly\Entity\Merchant;

class CustomerMigratePresenter extends AbstractPresenter
{
    protected $public = false;

    public function __construct(Merchant $merchant, Customer $customer, $email, $reference, $locale = 'en')
    {
        parent::__construct($merchant);

        $this->data = array(
            'meta' => array(
                'locale' => $locale,
                'issuerData' => array(
                    array(
                        'field' => 'expressly_path',
                        'value' => $merchant->getPath()
                    )
                )
            ),
            'data' => array(
                'email' => $email,
                'userReference' => $reference,
                'customerData' => $customer->toArray()
            )
        );
    }
}