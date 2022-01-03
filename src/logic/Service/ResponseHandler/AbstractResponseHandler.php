<?php

namespace App\Service\ResponseHandler;

use App\Service\AbstractService;

abstract class AbstractResponseHandler extends AbstractService
{
    /**
     * @param mixed $response
     * @param array $headers
     */
    public function __construct(protected mixed $response, protected array $headers = [])
    {
    }

    /**
     * @return bool
     */
    abstract public function isValidStrategy(): bool;

    /**
     * @return void
     */
    public function send()
    {
        $this->sendHeaders();
        $this->writeResponse();
    }

    /**
     * @return void
     */
    protected function sendHeaders(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }
    }

    /**
     * @return void
     */
    protected function writeResponse(): void
    {
        echo $this->response;
    }
}
