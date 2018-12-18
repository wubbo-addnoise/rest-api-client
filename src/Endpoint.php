<?php

namespace RestApiClient;

class Endpoint
{
    protected $name;
    protected $id;
    protected $parent;

    public function __construct($name, $id = null, Endpoint $parent = null)
    {
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

    public function __call($name, $arguments)
    {
        $id = count($arguments) > 0 ? $arguments[0] : null;
        $endpoint = new Endpoint($name, $id, $this);
        return $endpoint;
    }
}
