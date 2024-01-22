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
