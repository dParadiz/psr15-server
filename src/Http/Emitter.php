<?php

namespace Product\Http;

use Psr\Http\Message\ResponseInterface;

class Emitter
{
    /**
     * Emits response if headers weren't sent already
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    public static function emit(ResponseInterface $response)
    {
        if (headers_sent()) {
            return;
        }

        $httpLine = sprintf(
            'HTTP/%s %d %s',
            (string)$response->getProtocolVersion(),
            (int)$response->getStatusCode(),
            (string)$response->getReasonPhrase()
        );

        header($httpLine, true, (int)$response->getStatusCode());

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }

        $stream = $response->getBody();

        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        while (!$stream->eof()) {
            echo $stream->read(1024 * 8);
        }
    }
}
