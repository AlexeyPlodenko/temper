<?php

namespace App\Service\ResponseHandler;

class JsonResponseHandler extends AbstractResponseHandler
{
    /**
     * @param mixed $response
     * @param array $headers
     */
    public function __construct(mixed $response, array $headers = [])
    {
        // @TODO make this lazy
        $headers[] = 'Content-Type: application/json; charset=utf-8';

        parent::__construct($response, $headers);
    }

    /**
     * @return bool
     */
    public function isValidStrategy(): bool
    {
        return is_array($this->response);
    }

    /**
     * @return void
     */
    protected function writeResponse(): void
    {
        echo json_encode($this->response);
    }
}
