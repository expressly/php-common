<?php

namespace Expressly\Exception;

class ExceptionFormatter
{
    public static function format(\Exception $exception)
    {
        if ($exception instanceof GenericException) {
            return (string)$exception;
        }

        return sprintf(
            '%s-%s (%s::%u)',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
    }
}