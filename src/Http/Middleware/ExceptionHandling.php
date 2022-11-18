<?php

namespace Product\Http\Middleware;

use Product\Http\Exception\BadRequest;
use Product\Http\Exception\InternalServerError;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExceptionHandling implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (BadRequest $e) {

            return new Response(
                400,
                [
                    'Content-Type' => 'application/json',
                ],
                json_encode([
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                ])
            );

        } catch (\Throwable|InternalServerError $e) {

            return new Response(
                500,
                [
                    'Content-Type' => 'application/json',
                ],
                json_encode([
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                ])
            );
        }

    }
}