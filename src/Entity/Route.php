<?php

namespace Expressly\Entity;

use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\RequestInterface;
use Buzz\Message\Response;
use Expressly\Exception\InvalidURIException;

class Route
{
    const MAX_RETRIES = 3;

    private $host;
    private $uri;
    private $method;
    private $parameters = array();
    private $rules = array();
    private $retries = 1;

    public function setParameters(Array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function process($callback = null)
    {
        $response = new Response();
        $request = new Request($this->getMethod(), '/', $this->getURL());
        $request->setProtocolVersion(1.1);
        $request->addHeader('Content-Type: application/json');
        $client = new Curl();
        $client->setTimeout(3);
        $client->setIgnoreErrors(true);

        if (is_callable($callback)) {
            // Add any additions to the Response
            $callback($request);
        }

        $request->setContent(json_encode($request->getContent()));
        $client->send($request, $response);

        // To account for timeouts, retry up to MAX_RETRIES
        $content = $response->getContent();
        if ($response->isEmpty() && empty($content) && $this->retries <= self::MAX_RETRIES) {
            $this->retries++;
            $this->process($callback);
        }

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

    public function getURL()
    {
        return $this->host . $this->getURI();
    }

    public function getURI()
    {
        if (empty($this->parameters)) {
            if (!empty($this->rules)) {
                throw new InvalidURIException(reset($this->rules)->getMessage());
            }

            return $this->uri;
        }

        $uri = $this->uri;
        foreach ($this->parameters as $parameter => $value) {
            if (isset($this->rules[$parameter]) && !$this->rules[$parameter]->validate($value)) {
                throw new InvalidURIException($this->rules[$parameter]->getMessage());
            }

            $uri = str_replace("<$parameter>", $value, $uri);
        }

        return $uri;
    }

    public function setURI($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function setRules(Array $rules)
    {
        $this->rules = $rules;

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