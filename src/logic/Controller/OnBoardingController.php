<?php

namespace App\Controller;

use App\Exception\Http\ServerSideHttpException;
use App\Exception\Service\FileLoader\AbstractFileLoaderServiceException;
use App\Service\FileLoader\JsonFileLoaderService;
use App\Service\FileLoader\TsvFileLoaderService;
use DateInterval;
use DateTime;
use Exception;
use JsonException;

class OnBoardingController extends AbstractController
{
    /**
     * @return array
     * @throws ServerSideHttpException
     */
    public function users(): array
    {
        $jsonFile = new JsonFileLoaderService(BASEDIR .'/data/export.json');
        $tsvFile = new TsvFileLoaderService(BASEDIR .'/data/export.tsv');

        try {
            $data = array_merge(
                $jsonFile->getAll(),
                $tsvFile->getAll()
            );
        } catch (AbstractFileLoaderServiceException $ex) {
            // we catch only the expected exceptions. The rest will be handled by the app's logic
            throw new ServerSideHttpException($ex->getMessage());
        }

        return $data;
    }

    /**
     * @return array
     * @throws ServerSideHttpException
     * @throws Exception
     */
    public function stats(): array
    {
        $users = $this->users();

        $yearWeeks = [];
        foreach ($users as $user) {
            $userDate = new DateTime($user['created_at']);

            $yearWeek = $userDate->format('Y-W');
            if (!isset($yearWeeks[$yearWeek])) {
                $userDateWeekDay = $userDate->format('N');
                if ($userDateWeekDay != 1) {
                    // we need to rewind the date to Monday, to get the start of the week date for the graph

                    // cloning the original object, to prevent modification
                    $userDateMonday = clone $userDate;
                    $daysTillMonday = $userDateWeekDay - 1;
                    $interval = new DateInterval('P'. ($daysTillMonday) .'D');
                    $userDateMonday->sub($interval);
                } else {
                    $userDateMonday = $userDate;
                }

                $yearWeeks[$yearWeek] = $userDateMonday->format('Y-m-d');
            }
//            dd($user);
        }
        ksort($yearWeeks);
dd($yearWeeks);

        $stats = [];

        return $stats;
    }
}
