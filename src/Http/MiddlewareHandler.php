<?php

namespace Product\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MiddlewareHandler implements RequestHandlerInterface
{
    /** @var MiddlewareInterface[] */
    private array $middleware = [];

    public function __construct(
        private readonly RequestHandlerInterface $handler
    )
    {
    }


    public function withMiddleware(MiddlewareInterface $middleware): self
    {
        $this->middleware[] = $middleware;

        return $this;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->middleware === []) {
            return $this->handler->handle($request);
        }

        $handler = array_reduce(
            $this->middleware,
            fn(
                RequestHandlerInterface $handler,
                MiddlewareInterface     $middleware
            ) => new MiddlewareAwareHandler($handler, $middleware),
            $this->handler
        );

        return $handler->handle($request);
    }
}