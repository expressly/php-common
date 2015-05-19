<?php

namespace Expressly\Entity;

use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\RequestInterface;
use Buzz\Message\Response;

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

    public function process($callback)
    {
        $response = new Response();
        $request = new Request($this->getMethod(), '/', $this->getURL());
        $client = new Curl();

        // Add any additions to the Response
        $callback($request);

        $client->send($request, $response);

        return $response->getContent();
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

    public function getURL()
    {
        return $this->host . $this->uri;
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
}