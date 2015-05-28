<?php

namespace Expressly\Event;

use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    private $response;

    public function getResponse()
    {
        return is_array($this->response) ? $this->response : json_decode($this->response, true);
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}