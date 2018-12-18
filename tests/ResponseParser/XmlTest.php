<?php

use PHPUnit\Framework\TestCase;
use RestApiClient\ResponseParser\Xml;

class RestApiClient_ResponseParser_XmlTest extends TestCase
{
    protected $xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?" . ">\n";

    public function testParse()
    {
        $parser = new Xml();
        $data = $parser->parse($this->xmlHeader . '<root><item attribute="value">Content</item></root>');

        $this->assertInternalType("array", $data);
        $this->assertArrayHasKey("root", $data);
        $this->assertArrayHasKey("item", $data["root"]);
        $this->assertArrayHasKey("attribute", $data["root"]["item"]);
        $this->assertEquals("value", $data["root"]["item"]["attribute"]);
        $this->assertArrayHasKey("content", $data["root"]["item"]);
        $this->assertEquals("Content", $data["root"]["item"]["content"]);
    }

    public function testMultiTag()
    {
        $parser = new Xml();
        $data = $parser->parse($this->xmlHeader . '<root><item attribute="value">Content</item><item attribute="value2">Content 2</item></root>');

        $this->assertInternalType("array", $data);
        $this->assertArrayHasKey("root", $data);
        $this->assertArrayHasKey("item", $data["root"]);
        $this->assertInternalType("array", $data["root"]["item"]);
        $this->assertCount(2, $data["root"]["item"]);
        $this->assertArrayHasKey("attribute", $data["root"]["item"][0]);
        $this->assertEquals("value", $data["root"]["item"][0]["attribute"]);
        $this->assertArrayHasKey("content", $data["root"]["item"][0]);
        $this->assertEquals("Content", $data["root"]["item"][0]["content"]);
        $this->assertArrayHasKey("attribute", $data["root"]["item"][1]);
        $this->assertEquals("value2", $data["root"]["item"][1]["attribute"]);
        $this->assertArrayHasKey("content", $data["root"]["item"][1]);
        $this->assertEquals("Content 2", $data["root"]["item"][1]["content"]);
    }
}
