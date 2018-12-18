<?php

namespace RestApiClient;

use Psr\Http\Message\StreamInterface;

class StringStream implements StreamInterface
{
    protected $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->content;
    }

    public function close()
    {

    }

    public function detach()
    {

    }

    public function getSize()
    {
        return strlen($this->content);
    }

    public function tell()
    {
        return 0;
    }

    public function eof()
    {
        return $this->tell() >= strlen($content);
    }

    public function isSeekable()
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new \RuntimeException("seek() cannot be used on StringStream");
    }

    public function rewind()
    {
        throw new \RuntimeException("rewind() cannot be used on StringStream");
    }

    public function isWritable()
    {
        return false;
    }

    public function write($string)
    {
        throw new \RuntimeException("write() cannot be used on StringStream");
    }

    public function isReadable()
    {
        return true;
    }

    public function read($length)
    {
        return substr($this->content, 0, $length);
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function getMetadata($key = null)
    {
        return null;
    }
}
