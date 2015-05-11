<?php

namespace Expressly\Entity;

use Buzz\Message\Request;
use Buzz\Message\RequestInterface;

class Route
{
    private $host;
    private $uri;
    private $method;
    private $password;

    public function __construct($host, $uri, $method = null, $password = false)
    {
        $this->host = $host;
        $this->uri = $uri;
        $this->method = RequestInterface::METHOD_GET;
        $this->password = $password;

        $methods = array(
            RequestInterface::METHOD_GET,
            RequestInterface::METHOD_HEAD,
            RequestInterface::METHOD_POST,
            RequestInterface::METHOD_PUT,
            RequestInterface::METHOD_DELETE,
            RequestInterface::METHOD_PATCH
        );

        if (in_array($method, $methods)) {
            $this->method = $method;
        }
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getURI()
    {
        return $this->uri;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRequest()
    {
        return new Request($this->getMethod(), $this->getURI(), $this->getHost());
    }

    public function getURL()
    {
        return $this->host . $this->uri;
    }

    public function __toString()
    {
        return (string)$this->getURL();
    }
}