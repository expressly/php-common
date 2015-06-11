<?php

namespace Expressly\Exception;

class GenericException extends \Exception
{
    public function __toString()
    {
        return (string)sprintf(
            '%s-%s (%s::%u)',
            __CLASS__,
            $this->getMessage(),
            $this->getFile(),
            $this->getLine()
        );
    }
}