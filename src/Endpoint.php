<?php

namespace RestApiClient;

class Endpoint
{
    protected $client;
    protected $name;
    protected $id;
    protected $parent;

    public function __construct(Client $client, $name, $id = null, Endpoint $parent = null)
    {
        $this->client = $client;
        $this->name = $name;
        $this->id = $id;
        $this->parent = $parent;
    }

    public function getPath()
    {
        $path = "";
        if ($this->parent) $path = $this->parent->getPath();
        $path .= "/{$this->name}";
        if ($this->id) $path .= "/{$this->id}";

        return $path;
    }

    public function get($params = null)
    {
        return $this->client->get($this->getPath(), $params);
    }

    public function put($params = null)
    {
        return $this->client->put($this->getPath(), $params);
    }

    public function post($params = null)
    {
        return $this->client->post($this->getPath(), $params);
    }

    public function delete()
    {
        return $this->client->delete($this->getPath());
    }

    public function __call($name, $arguments)
    {
        $id = count($arguments) > 0 ? $arguments[0] : null;
        $endpoint = new Endpoint($this->client, $name, $id, $this);
        return $endpoint;
    }
}
