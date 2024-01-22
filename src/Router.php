<?php

namespace Diego03\Router;

class Router
{

    public $routes = [];

    private function addRoute($method, string $path, callable $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function get(string $path, callable $handler)
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, callable $handler)
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function patch(string $path, callable $handler)
    {
        $this->addRoute('PATCH', $path, $handler);
    }

    public function delete(string $path, callable $handler)
    {
        $this->addRoute('DELETE', $path, $handler);
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
