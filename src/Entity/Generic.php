<?php

namespace Expressly\Entity;

class Generic extends ArraySerializeable
{
    protected $field;
    protected $value;

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}