<?php

namespace Expressly\Entity;

use Doctrine\Common\Collections\ArrayCollection;

abstract class ArraySerializeable
{
    public function toArray()
    {
        $data = get_object_vars($this);
        $data = array_filter($data, function($item) {
            return !is_null($item) && $item !== '';
        });

        array_walk_recursive($data, function (&$element) {
            if ($element instanceof ArraySerializeable) {
                $element = $element->toArray();
            }
            if ($element instanceof ArrayCollection) {
                $element = $element->toArray();
                array_walk($element, function (&$item) {
                    $item = $item->toArray();
                });
            }
        });

        return $data;
    }
}