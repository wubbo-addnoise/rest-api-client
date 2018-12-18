<?php

use PHPUnit\Framework\TestCase;
use RestApiClient\ResponseParser\Json;

class RestApiClient_ResponseParser_JsonTest extends TestCase
{
    public function testParse()
    {
        $parser = new Json();
        $data = $parser->parse('{"dingen":"zaken"}');

        $this->assertInternalType("object", $data);
        $this->assertObjectHasAttribute("dingen", $data);
        $this->assertEquals("zaken", $data->dingen);
    }

    public function testAssocArray()
    {
        $parser = new Json(true);
        $data = $parser->parse('{"dingen":"zaken"}');

        $this->assertInternalType("array", $data);
        $this->assertArrayHasKey("dingen", $data);
        $this->assertEquals("zaken", $data["dingen"]);
    }
}
