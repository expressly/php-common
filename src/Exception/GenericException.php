<?php

namespace Expressly\Exception;

class GenericException extends \Exception
{
    public function __toString()
    {
        $time = new \DateTime('now', new \DateTimeZone('UTC'));

        return (string)sprintf(
            '[%s] %s (%s::%u)',
            $time->format(\DateTime::ISO8601),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine()
        );
    }
}