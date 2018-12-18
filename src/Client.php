<?php

namespace RestApiClient;

use RestApiClient\AuthAdapter\AuthAdapterInterface;
use RestApiClient\ResponseParser\ResponseParserInterface;
use Zend\Diactoros\Request;

class Client
{
    protected $baseUrl;
    protected $initialized = false;
    protected $auth;
    protected $responseParser;

    public function __construct($baseUrl, AuthAdapterInterface $auth, ResponseParserInterface $responseParser)
    {
        $this->baseUrl = $baseUrl;
        $this->auth = $auth;
        $this->responseParser = $responseParser;
    }

    protected function httpRequest($method, $url, $postData = null)
    {
        if (!$this->initialized) {
            $this->auth->init();
            $this->initialized = true;
        }

        $request = new Request("{$this->baseUrl}{$url}", $method, new StringStream($postData??""));
        $request = $this->auth->authenticateRequest($request);

        $headersFlat = [];
        foreach ($request->getHeaders() as $header => $value) {
            $headersFlat[] = "{$header}: " . implode("; ", $value);
        }

        $ch = curl_init((string)$request->getUri());
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $headersFlat
        ]);

        if (strtoupper($request->getMethod()) == "POST") {
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => (string)$request->getBody()
            ]);
        }

        $response = curl_exec($ch);
        $result = $this->responseParser->parse($response);

        return $result;
    }

    public function get($url, $params = null)
    {
        if (!empty($params)) {
            $url .= "?" . http_build_query($params);
        }
        return $this->httpRequest("GET", $url);
    }

    public function put($url, $params = null)
    {
        return $this->httpRequest("PUT", $url, $params);
    }

    public function post($url, $params = null)
    {
        return $this->httpRequest("POST", $url, $params);
    }

    public function delete($url)
    {
        return $this->httpRequest("DELETE", $url);
    }

    public function __call($name, $arguments)
    {
        $id = count($arguments) > 0 ? $arguments[0] : null;
        $endpoint = new Endpoint($this, $name, $id);
        return $endpoint;
    }
}
