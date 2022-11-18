<?php


namespace Product\Http\Handler;

use GuzzleHttp\Psr7\Response;
use Product\Http\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PipelineHandler implements RequestHandlerInterface
{
    public function __construct(private readonly Pipeline $pipeline)
    {
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $this->pipeline->execute($request);

        return new Response(200, [
            'Content-Type' => 'application/json',
        ], $body);
    }
}

