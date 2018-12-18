<?php

namespace RestApiClient\ResponseParser;

interface ResponseParserInterface
{
    public function parse(string $data);
}
