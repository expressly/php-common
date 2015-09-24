<?php

namespace Expressly\Validator;

class EmailValidator implements ValidatorInterface
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function validate($data)
    {
        if (!is_string($data)) {
            return false;
        }

        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getType()
    {
        return 'email';
    }
}