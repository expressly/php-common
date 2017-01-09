<?php

namespace Expressly\Entity;

class PaymentMethod extends ArraySerializeable
{
    protected $expresslyToken;

    public function getExpresslyToken()
    {
        return $this->expresslyToken;
    }

    public function setExpresslyToken($expresslyToken)
    {
        $this->expresslyToken = $expresslyToken;
        return $this;
    }
}