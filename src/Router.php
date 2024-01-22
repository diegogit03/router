<?php

namespace Diego03\Router;

use Diego03\PathToRegexp\PathParser;

class Router
{

    public PathParser $parser;

    public array $routes = [];

    public function __construct()
    {
        $this->parser = new PathParser();
    }

    private function addRoute($method, string $path, callable $handler)
    {
        $this->routes[] = [
            'regex' => $this->parser->toRegex($path),
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
                if ($route['regex']->match($url)->test()) {
                    $params = [];

                    $matcher = $route['regex']->match($url);

                    $groups = $matcher->first()->namedGroups();
                    foreach ($groups as $key => $group) {
                        $params[$key] = $group->text();
                    }

                    return [
                        'handler'  => $route['handler'],
                        'path'  => $route['path'],
                        'params'  => $params,
                    ];
                }
            }
        }

        return null;
    }
}
