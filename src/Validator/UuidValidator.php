<?php

namespace Expressly\Validator;

class UuidValidator implements ValidatorInterface
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

        if (preg_match('/^([\w]{8}-([\w]{4}-){3}[\w]{12})$/', $data) != false) {
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
        return 'uuid_string';
    }
}