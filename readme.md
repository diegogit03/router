# Router

A very simpler and without opnion router. is a good library for integrate with your framework.

## basic usage

A simpler example of a json api:

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Diego03\Router\Router;

$router = new Router();

$router->get('/', function () {
    return [
        'message' => 'Hello World!'
    ];
});

$router->get('/users/:id', function ($id) {
    return [
        'id' => $id
    ];
});

$route = $router->match(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

echo json_encode(
    $route['handler'](
        ...$route['params']
    )
);
```

## Feature roadmap

-   [x] Support all basic http methods
-   [x] path params
-   [x] Group routing
-   [ ] Domain routing
-   [ ] Middlewares
