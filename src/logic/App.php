<?php

namespace App;

use App\Controller\OnBoardingController;
use App\Exception\Http\AbstractHttpException;
use App\Exception\Http\ServerSideHttpException;
use App\Service\ResponseHandler\JsonResponseHandler;
use App\Service\ResponseService;
use Exception;

class App extends AbstractClass
{
    /**
     * @param ResponseService $responseService
     */
    public function __construct(protected ResponseService $responseService)
    {
        $this->responseService->registerResponseHandlers(JsonResponseHandler::class);
    }

    /**
     * Routes the request to the proper controller's action.
     *
     * @param string $action
     * @return void
     */
    public function route(string $action): void
    {
        // @TODO implement mapping of the controllers to the routes

        try {
            // hardcoded controller for now. This will be replaced later with some logic.
            $controller = new OnBoardingController();
            $output = $controller->$action();
            $this->responseService->output($output);

        } catch (AbstractHttpException $ex) {
            // let's send the HTTP exception to the output, as the response service knows how to cater for those
            $this->responseService->output($ex);

        } catch (Exception) {
            // we send all generic exception as 500 error
            // @TODO output to original error message and the stacktrace
            $ex = new ServerSideHttpException();
            $this->responseService->output($ex);
        }
    }
}
