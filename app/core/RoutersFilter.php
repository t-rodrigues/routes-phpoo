<?php

namespace app\core;

use app\routes\Routes;
use app\support\RequestType;
use app\support\Uri;

class RoutersFilter
{
    private string $uri;
    private string $method;
    private array $routesRegistered;

    public function __construct()
    {
        $this->uri = Uri::get();
        $this->method = RequestType::get();
        $this->routesRegistered = Routes::get();
    }

    private function simpleRouter(): string | null
    {
        if (array_key_exists($this->uri, $this->routesRegistered[$this->method])) {
            return $this->routesRegistered[$this->method][$this->uri];
        }
        return null;
    }

    private function dynamicRouter(): string | null
    {
        $router = null;
        foreach ($this->routesRegistered[$this->method] as $index => $route) {
            $regex = str_replace('/', '\/', ltrim($index, '/'));
            if ($index !== '/' && preg_match("/^$regex$/", ltrim($this->uri, '/'))) {
                return $router = $route;
            }
        }

        return $router;
    }

    public function get()
    {
        $router = $this->simpleRouter() ?: $this->dynamicRouter();

        if ($router) {
            return $router;
        }

        return 'NotFoundController@index';
    }
}
