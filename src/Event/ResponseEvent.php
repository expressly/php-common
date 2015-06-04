<?php

namespace Expressly\Event;

use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    private $response;

    public function getResponse()
    {
        return $this->isSuccessful();
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    private function isSuccessful()
    {
        $response = $this->decode();

        // TODO: Autocast to an exception instead of matching keys
        $errorKeys = array(
            'id',
            'message',
            'description'
        );

        if (is_array($response) && count(array_diff($response, $errorKeys)) == 0) {
            return array();
        }

        return $response;
    }

    private function decode()
    {
        if (is_array($this->response)) {
            return $this->response;
        }

        $json = json_decode($this->response, true);

        return (json_last_error() == JSON_ERROR_NONE) ? $json : $this->response;
    }
}