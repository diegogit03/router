<?php

namespace Diego03\Router;

use Diego03\PathToRegexp\PathParser;
use Psr\Http\Message\RequestInterface;

class Router
{
    public PathParser $parser;

    public array $routes = [];

    public $openedGroup = null;

    public function __construct()
    {
        $this->parser = new PathParser();
    }

    private function addRoute($method, string $path, callable $handler)
    {
        $route = [
            'type' => 'route',
            'regex' => $this->parser->toRegex($path),
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];

        if ($this->openedGroup) {
            $route['regex'] = $this->parser->toRegex('/users');
            $this->openedGroup['routes'][] = $route;
            return;
        }

        $this->routes[] = $route;
    }

    public function group(string $prefix, callable $handler)
    {
        $this->openedGroup = [
            'type' => 'group',
            'prefix' => $prefix,
            'routes' => []
        ];

        $handler();

        $this->routes[] = $this->openedGroup;
        $this->openedGroup = null;
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

    public function match(RequestInterface $request)
    {
        $method = $request->getMethod();
        $url = $request->getUri()->getPath();

        foreach ($this->routes as $route) {
            if ($route['type'] === 'group') {
                foreach ($route['routes'] as $groupRoute) {
                    if ($method === $groupRoute['method']) {
                        if ($groupRoute['regex']->match($url)->test()) {
                            $params = [];

                            $matcher = $groupRoute['regex']->match($url);

                            $groups = $matcher->first()->namedGroups();
                            foreach ($groups as $key => $group) {
                                $params[$key] = $group->text();
                            }

                            return [
                                'handler'  => $groupRoute['handler'],
                                'path'  => $groupRoute['path'],
                                'params'  => $params,
                            ];
                        }
                    }
                }
            }

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
