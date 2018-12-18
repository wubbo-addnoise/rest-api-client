<?php

namespace RestApiClient\AuthAdapter;

use Psr\Http\Message\RequestInterface;

interface AuthAdapterInterface
{
    public function init();
    public function authenticateRequest(RequestInterface $request);
}
