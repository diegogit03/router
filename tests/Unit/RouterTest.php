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
