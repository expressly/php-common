<?php

namespace Expressly\Entity;

class Merchant extends ArraySerializeable
{
    const PASSWORD_LENGTH = 16;
    protected $id;
    protected $host;
    protected $password;
    protected $offer = true;
    protected $destination;
    protected $path;

    public static function compare(Merchant $a, Merchant $b)
    {
        if ($a->getHost() != $b->getHost()) {
            return false;
        }

        if ($a->getPassword() != $b->getPassword()) {
            return false;
        }

        if ($a->getOffer() != $b->getOffer()) {
            return false;
        }

        if ($a->getDestination() != $b->getDestination()) {
            return false;
        }

        return true;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getOffer()
    {
        return (bool)$this->offer;
    }

    public function setOffer($offer)
    {
        $this->offer = (bool)$offer;

        return $this;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    public static function createPassword()
    {
        return bin2hex(openssl_random_pseudo_bytes(self::PASSWORD_LENGTH));
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}