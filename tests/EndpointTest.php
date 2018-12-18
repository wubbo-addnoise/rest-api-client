<?php

use PHPUnit\Framework\TestCase;
use RestApiClient\Client;
use RestApiClient\Endpoint;
use RestApiClient\AuthAdapter\None;
use RestApiClient\ResponseParser\Json;

class RestApiClient_EndpointTest extends TestCase
{
    public function testSinglePath()
    {
        $client = new Client("http://localhost:8080", new None(), new Json(true));
        $endpoint = new Endpoint($client, "objects");
        $this->assertEquals("/objects", $endpoint->getPath());

        $endpoint = new Endpoint($client, "objects", 1234);
        $this->assertEquals("/objects/1234", $endpoint->getPath());
    }

    public function testComplexPath()
    {
        $client = new Client("http://localhost:8080", new None(), new Json(true));
        $endpoint = new Endpoint($client, "objects", 1234);
        $attributes = $endpoint->attributes();

        $this->assertEquals("/objects/1234/attributes", $attributes->getPath());

    }
}
