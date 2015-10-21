<?php

namespace Expressly\Entity;

class Merchant extends ArraySerializeable
{
    protected $apiKey;
    protected $host;
    protected $path;
    private $uuid;
    private $password;

    public static function compare(Merchant $a, Merchant $b)
    {
        if ($a->getApiKey() != $b->getApiKey()) {
            return false;
        }

        if ($a->getEndpoint() != $b->getEndpoint()) {
            return false;
        }

        return true;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        $userPassword = explode(':', base64_decode($this->apiKey));
        if (count($userPassword) === 2) {
            list($this->uuid, $this->password) = $userPassword;
        }

        return $this;
    }

    public function getEndpoint()
    {
        return $this->host . $this->path;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getPassword()
    {
        return $this->password;
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

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}