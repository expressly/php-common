<?php

namespace Expressly\Validator;

interface ValidatorInterface
{
    public function validate($data);

    public function getMessage();

    public static function getType();
}