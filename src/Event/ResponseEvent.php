<?php

namespace Expressly\Event;

use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    private $response;

    public function getResponse()
    {
        if (is_array($this->response)) {
            return $this->response;
        }

        return (json_last_error() == JSON_ERROR_NONE) ? json_decode($this->response, true) : $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}