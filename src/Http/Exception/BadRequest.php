<?php


namespace Product\Http\Exception;

class BadRequest extends HttpException
{
    /** @var string */
    protected $message = 'Bad request';

    /** @var int  */
    protected $code = 400;
}
