<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Product\Http\Emitter;
use Product\Http\Middleware\ExceptionHandling;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router as SymfonyRouter;

require_once __DIR__ . '/../vendor/autoload.php';
$di = include __DIR__ . "/../config/di.services.php";

define('PROJECT_PATH', dirname(__DIR__));


$router = new SymfonyRouter(
    new PhpFileLoader(new FileLocator(__DIR__ . '/../config/')),
    'routes.php',
    [
        'cache_dir' => __DIR__ . '/../var/routes',
    ],
    new RequestContext()
);

$request = ServerRequest::fromGlobals();


try {
    $router->setContext(new RequestContext('', method: $request->getMethod()));
    $parameters = $router->match($request->getUri()->getPath());
} catch (RouteNotFoundException|ResourceNotFoundException $e) {
    Emitter::emit(new Response(404, [], 'No matching route'));
    return;
}

$handler = $di->get($parameters['handler']);

$serverRequestHandler = new \Product\Http\MiddlewareHandler($handler);
$serverRequestHandler->withMiddleware(new ExceptionHandling());

$response = $serverRequestHandler->handle($request);

Emitter::emit($response);