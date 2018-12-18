<?php

namespace RestApiClient\ResponseParser;

use DOMDocument;

class Xml implements ResponseParserInterface
{
    public function parse(string $data)
    {
        $dom = new DOMDocument();
        $dom->loadXML($data);

        $result = [];
        $tag = $dom->documentElement->nodeName;
        $result[$tag] = $this->nodeToArray($dom->documentElement);

        return $result;
    }

    protected function nodeToArray($node)
    {
        $result = [];
        foreach ($node->attributes as $attr) {
            $result[$attr->name] = $attr->value;
        }

        $content = "";
        for ($child = $node->firstChild; $child; $child = $child->nextSibling) {
            if ($child->nodeType == XML_TEXT_NODE || $child->nodeType == XML_CDATA_SECTION_NODE) {
                $content .= $child->textContent;
            } else if ($child->nodeType == XML_ELEMENT_NODE) {
                $ctag = $child->nodeName;
                if (isset($result[$ctag])) {
                    if (!array_key_exists(0, $result[$ctag])) {
                        $result[$ctag] = [ $result[$ctag] ];
                    }
                    $result[$ctag][] = $this->nodeToArray($child);
                } else {
                    $result[$ctag] = $this->nodeToArray($child);
                }
            }
        }

        if (!empty($content)) {
            $result["content"] = $content;
        }

        return $result;
    }
}
