<?php

namespace Expressly\Event;

use Buzz\Message\Response;
use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    private $response;

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function isSuccessful()
    {
        if (!$this->response instanceof Response) {
            return false;
        }

        return $this->response->isSuccessful();
    }

    public function getContent()
    {
        if (!$this->response instanceof Response) {
            return null;
        }

        $content = $this->response->getContent();
        if (is_array($content)) {
            return $content;
        }

        $json = json_decode($content, true);

        return (json_last_error() == JSON_ERROR_NONE) ? $json : $content;
    }
}