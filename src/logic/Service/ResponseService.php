<?php

namespace App\Service;

use App\Service\ResponseHandler\AbstractResponseHandler;

class ResponseService extends AbstractService
{
    /**
     * @var string[]
     */
    protected array $responseHandlers;

    /**
     * @param mixed $output
     * @return void
     */
    public function output(mixed $output): void
    {
        $response = $this->makeResponse($output);
        assert($response);
        $response->send();
    }

    /**
     * @param string $responseHandler
     * @return void
     */
    public function registerResponseHandlers(string $responseHandler): void
    {
        $this->responseHandlers[] = $responseHandler;
    }

    /**
     * @param mixed $output
     * @return AbstractResponseHandler|false
     */
    protected function makeResponse(mixed $output): AbstractResponseHandler|false
    {
        foreach ($this->responseHandlers as $respHandler) {
            /** @var AbstractResponseHandler $response */
            $response = new $respHandler($output);
            $valid = $response->isValidStrategy();
            if ($valid) {
                return $response;
            }
        }

        return false;
    }
}
