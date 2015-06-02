<?php

namespace Expressly\Presenter;

use Expressly\Entity\Customer;
use Expressly\Entity\Merchant;

class CustomerMigratePresenter implements PresenterInterface
{
    private $merchant;
    private $customer;
    private $email;
    private $reference;

    public function __construct(Merchant $merchant, Customer $customer, $email, $reference, $locale = 'en')
    {
        $this->merchant = $merchant;
        $this->customer = $customer;
        $this->email = $email;
        $this->reference = $reference;
        $this->locale = $locale;
    }

    public function toArray()
    {
        return array(
            'meta' => array(
                'locale' => $this->locale,
                'issuerData' => array(
                    array(
                        'field' => 'expressly_path',
                        'value' => $this->merchant->getPath()
                    )
                )
            ),
            'data' => array(
                'email' => $this->email,
                'userReference' => $this->reference,
                'customerData' => $this->customer->toArray()
            )
        );
    }
}