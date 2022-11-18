<?php

namespace Product\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;


interface Deserializer
{
    public function __invoke(ServerRequestInterface $request): array;
}
