<?php

namespace Expressly\Entity;

use Buzz\Client\FileGetContents as BuzzClient;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\RequestInterface;

class Route
{
    private $host;
    private $uri;
    private $method;

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function process(callable $callback)
    {
        $request = new BuzzRequest();
        $response = new BuzzRequest($this->getMethod(), $this->getURI(), $this->getHost());
        $client = new BuzzClient();

        // Add any additions to the Response
        $callback($response);

        $client->send($request, $response);

        return $response;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = RequestInterface::METHOD_GET;

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

        return $this;
    }

    public function getURI()
    {
        if (empty($this->parameters)) {
            return $this->uri;
        }

        $uri = $this->uri;
        foreach ($this->parameters as $parameter => $value) {
            $uri = str_replace("<$parameter>", $value, $uri);
        }

        return $uri;
    }

    public function setURI($uri)
    {
        $this->uri = $uri;

        return $this;
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

    public function __toString()
    {
        return (string)$this->getURL();
    }

    public function getURL()
    {
        return $this->host . $this->uri;
    }
}