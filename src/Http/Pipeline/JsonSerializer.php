<?php


namespace Product\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

class JsonSerializer implements StepInterface
{
    public function handle($context, ServerRequestInterface $request): string
    {
        return json_encode($context);
    }
}
