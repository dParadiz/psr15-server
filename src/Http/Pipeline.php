<?php

namespace Product\Http;

use Psr\Http\Message\ServerRequestInterface;

final class Pipeline
{
    private array $pipeline = [];

    public function __construct(array $steps = [])
    {
        foreach ($steps as $step) {
            $this->addStep($step);
        }
    }

    public function addStep(callable $step): self
    {
        $this->pipeline[] = $step;
        return $this;
    }

    public function execute(ServerRequestInterface $request): string
    {
        $payload = [$request];

        foreach ($this->pipeline as $step) {
            $payload = $payload === [] ? $step() : $step(...$payload);
            if (!is_array($payload)) {
                $payload = [$payload];
            }
        }
        // todo ensure string output -- since serialization and deserialization is generated this should do but still
        return reset($payload);
    }
}
