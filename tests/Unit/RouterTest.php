<?php

use Diego03\Router\Router;

it('Should match a GET method route', function () {
    $router = new Router();
    $router->get('/', fn () => 'Hello world!');

    $result = $router->match('GET', '/');

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a POST method route', function () {
    $router = new Router();
    $router->post('/', fn () => 'Hello world!');

    $result = $router->match('POST', '/');

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a PUT method route', function () {
    $router = new Router();
    $router->put('/', fn () => 'Hello world!');

    $result = $router->match('PUT', '/');

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a PATCH method route', function () {
    $router = new Router();
    $router->patch('/', fn () => 'Hello world!');

    $result = $router->match('PATCH', '/');

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a DELETE method route', function () {
    $router = new Router();
    $router->delete('/', fn () => 'Hello world!');

    $result = $router->match('DELETE', '/');

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a route with params', function () {
    $router = new Router();
    $router->get('/:id', fn () => 'Hello world!');

    $result = $router->match('GET', '/1');

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path', 'params']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a route with optional params', function () {
    $router = new Router();
    $router->get('/:id?', fn () => 'Hello world!');

    $resultWithParam = $router->match('GET', '/1');
    $resultWithoutParam = $router->match('GET', '/');

    expect($resultWithParam)->not->toBe(null);
    expect($resultWithParam)->toHaveKeys(['handler', 'path', 'params']);
    expect($resultWithParam['handler']())->toBe('Hello world!');

    expect($resultWithoutParam)->not->toBe(null);
    expect($resultWithoutParam)->toHaveKeys(['handler', 'path', 'params']);
    expect($resultWithoutParam['handler']())->toBe('Hello world!');
});

it('Should match a route group', function () {
    $router = new Router();
    $router->group('/users', function () use ($router) {
        $router->get('/', fn () => 'get test');
        $router->post('/', fn () => 'post test');
    });

    $result = $router->match('GET', '/users');
    $postresult = $router->match('POST', '/users');

    expect($result)->not()->toBe(null);
    expect($result['handler']())->toBe('get test');

    expect($postresult)->not()->toBe(null);
    expect($postresult['handler']())->toBe('post test');
});
