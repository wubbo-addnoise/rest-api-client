<?php

use PHPUnit\Framework\TestCase;
use RestApiClient\Client;
use RestApiClient\AuthAdapter\None;
use RestApiClient\ResponseParser\Json;

class RestApiClient_ClientTest extends TestCase
{
    public function testBasic()
    {
        $client = new Client("http://localhost:8080", new None(), new Json(true));
        $result = $client->get("/objects");

        $this->assertInternalType("array", $result);
        $this->assertArrayHasKey("objects", $result);
        $this->assertCount(2, $result["objects"]);
        $this->assertEquals("Object 1", $result["objects"][0]["name"]);
        $this->assertEquals("Object type", $result["objects"][0]["type"]);
    }

    public function testPath()
    {
        $client = new Client("http://localhost:8080", new None(), new Json(true));
        $result = $client->objects(12)->get();

        $this->assertInternalType("array", $result);
        $this->assertArrayHasKey("object", $result);
        $this->assertEquals(12, $result["object"]["id"]);
        $this->assertEquals("Object 12", $result["object"]["name"]);
        $this->assertEquals("Object type", $result["object"]["type"]);

        $result = $client->objects(12)->attributes()->get();
        $this->assertInternalType("array", $result);
        $this->assertArrayHasKey("attributes", $result);
        $this->assertCount(2, $result["attributes"]);
        $this->assertEquals("Attribute 1", $result["attributes"][0]["name"]);
        $this->assertEquals("Attribute type", $result["attributes"][0]["type"]);
    }
}
