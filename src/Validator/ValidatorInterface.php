<?php

namespace Expressly\Validator;

interface ValidatorInterface
{
    public function validate($data);

    public function getMessage();

    public function getType();
}