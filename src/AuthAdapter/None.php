<?php

namespace RestApiClient\AuthAdapter;

use Psr\Http\Message\RequestInterface;

class None implements AuthAdapterInterface
{
    public function init()
    {

    }

    public function authenticateRequest(RequestInterface $request)
    {
        return $request;
    }
}
