<?php

namespace Expressly\Entity;

class Merchant extends ArraySerializeable
{
    protected $id;
    protected $uuid;
    protected $name;
    protected $host;
    protected $password;
    protected $offer = true;
    protected $destination;
    protected $path;
    protected $image;
    protected $terms;
    protected $policy;

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

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

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

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getEndpoint()
    {
        return $this->host . $this->path;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getTerms()
    {
        return $this->terms;
    }

    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    public function getPolicy()
    {
        return $this->policy;
    }

    public function setPolicy($policy)
    {
        $this->policy = $policy;

        return $this;
    }
}