<?php

namespace Product\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

interface StepInterface
{
    public function handle($context, ServerRequestInterface $request): string;
}