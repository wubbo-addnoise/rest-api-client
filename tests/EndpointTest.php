<?php

use PHPUnit\Framework\TestCase;
use RestApiClient\Endpoint;

class RestApiClient_EndpointTest extends TestCase
{
    public function testSinglePath()
    {
        $endpoint = new Endpoint("objects");
        $this->assertEquals("/objects", $endpoint->getPath());

        $endpoint = new Endpoint("objects", 1234);
        $this->assertEquals("/objects/1234", $endpoint->getPath());
    }

    public function testComplexPath()
    {
        $endpoint = new Endpoint("objects", 1234);
        $attributes = $endpoint->attributes();

        $this->assertEquals("/objects/1234/attributes", $attributes->getPath());

    }
}
