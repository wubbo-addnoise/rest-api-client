<?php

namespace RestApiClient\ResponseParser;

class Json implements ResponseParserInterface
{
    protected $assoc;

    public function __construct($assoc = false)
    {
        $this->assoc = $assoc;
    }

    public function parse(string $data)
    {
        return json_decode($data, $this->assoc);
    }
}
