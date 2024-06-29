<?php

use Diego03\Router\Router;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

function createRequest($method, $url): RequestInterface
{
    $uriMock = Mockery::mock(UriInterface::class);
    $requestMock = Mockery::mock(RequestInterface::class);

    $uriMock->shouldReceive('getPath')->andReturn($url);
    $requestMock->shouldReceive('getMethod')->andReturn($method);
    $requestMock->shouldReceive('getUri')->andReturn($uriMock);

    return $requestMock;
}

it('Should match a GET method route', function () {
    $router = new Router();
    $router->get('/', fn () => 'Hello world!');

    $result = $router->match(createRequest('GET', '/'));

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a POST method route', function () {
    $router = new Router();
    $router->post('/', fn () => 'Hello world!');

    $result = $router->match(createRequest('POST', '/'));

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a PUT method route', function () {
    $router = new Router();
    $router->put('/', fn () => 'Hello world!');

    $result = $router->match(createRequest('PUT', '/'));

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a PATCH method route', function () {
    $router = new Router();
    $router->patch('/', fn () => 'Hello world!');

    $result = $router->match(createRequest('PATCH', '/'));

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a DELETE method route', function () {
    $router = new Router();
    $router->delete('/', fn () => 'Hello world!');

    $result = $router->match(createRequest('DELETE', '/'));

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a route with params', function () {
    $router = new Router();
    $router->get('/:id', fn () => 'Hello world!');

    $result = $router->match(createRequest('GET', '/1'));

    expect($result)->not->toBe(null);
    expect($result)->toHaveKeys(['handler', 'path', 'params']);
    expect($result['handler']())->toBe('Hello world!');
});

it('Should match a route with optional params', function () {
    $router = new Router();
    $router->get('/:id?', fn () => 'Hello world!');

    $resultWithParam = $router->match(createRequest('GET', '/1'));
    $resultWithoutParam = $router->match(createRequest('GET', '/'));

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

    $result = $router->match(createRequest('GET', '/users'));
    $postresult = $router->match(createRequest('POST', '/users'));

    expect($result)->not()->toBe(null);
    expect($result['handler']())->toBe('get test');

    expect($postresult)->not()->toBe(null);
    expect($postresult['handler']())->toBe('post test');
});
