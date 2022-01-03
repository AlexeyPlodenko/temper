<?php

namespace App\Exception\Http;

class ServerSideHttpException extends AbstractHttpException
{
    /**
     * @var int
     */
    protected $code = 500;

    /**
     * @var string
     */
    protected $message = 'Internal Server Error';
}
