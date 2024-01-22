<?php

namespace Diego03\Router;

class Router
{

    public $routes = [];

    public function get(string $path, callable $handler)
    {
        $this->routes[] = [
            'method' => 'GET',
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function match(string $method, string $url)
    {
        foreach ($this->routes as $route) {
            if ($method === $route['method']) {
                if ($url === $route['path']) {
                    return $route;
                }
            }
        }

        return null;
    }
}
