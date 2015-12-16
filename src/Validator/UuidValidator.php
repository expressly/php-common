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

        if (preg_match('/^([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})$/', $data) != false) {
            return true;
        }

        return false;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public static function getType()
    {
        return 'uuid_string';
    }
}