<?php

namespace Product\Http\Exception;

class NotFoundException extends HttpException
{
    /** @var string */
    protected $message = 'Not found';

    /** @var int */
    protected $code = 404;
}
