<?php

namespace Product\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

class EmptyDeserializer implements Deserializer
{
    public function __invoke(ServerRequestInterface $request): array
    {
        return [];
    }
}
