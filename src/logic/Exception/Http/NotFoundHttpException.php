<?php

namespace App\Exception\Http;

class NotFoundHttpException extends AbstractHttpException
{
    /**
     * @var int
     */
    protected $code = 404;

    /**
     * @var string
     */
    protected $message = 'Not Found';
}
