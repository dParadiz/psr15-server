<?php


namespace Product\Http\Exception;

class InternalServerError extends HttpException
{
    /** @var string */
    protected $message = 'Internal server error';

    /** @var int */
    protected $code = 500;
}
