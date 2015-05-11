<?php

namespace Expressly\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Mapping\Entity
 */
class Merchant
{
    const PASSWORD_LENGTH = 16;
    /**
     * @Mapping\Column(type="integer")
     * @Mapping\Id
     * @Mapping\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Mapping\Column(type="string", length=255)
     */
    protected $host;

    /**
     * @Mapping\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @Mapping\Column(type="boolean")
     */
    protected $offer = true;

    /**
     * @Mapping\Column(type="string", length=255, nullable=true)
     */
    protected $destination;

    public function getId()
    {
        return $this->id;
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

    public function setPassword($password = null)
    {
        $this->password = !empty($password) ? $password : bin2hex(openssl_random_pseudo_bytes(self::PASSWORD_LENGTH));

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
}