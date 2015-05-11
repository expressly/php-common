<?php

namespace Expressly\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Meta extends ArraySerializeable
{
    protected $locale;
    protected $sender;
    protected $issuerData;

    public function __construct()
    {
        $this->setSender($_SERVER['SERVER_NAME']);
        $this->issuerData = new ArrayCollection();
    }

    public function addIssuerData(Generic $data)
    {
        $this->issuerData->add($data);

        return $this;
    }

    public function removeIssuerData(Generic $data)
    {
        $this->issuerData->removeElement($data);

        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    public function getIssuerData()
    {
        return $this->issuerData;
    }
}