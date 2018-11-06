<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 24 September 2018
 * Time: 20:00
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;
use DBLS\Exceptions\StationErrorException;
use DBLS\Model\TimetableData;

/**
 * Class that generates timetable
 *
 * @package DBLS\Controller
 */
class TimetableGenerator
{
    /**
     * Holds train categories
     */
    const CATEGORY_SBAHN = 'sbahn';
    const CATEGORY_RB = 'rb';
    const CATEGORY_RE = 're';
    const CATEGORY_IC = 'ic';
    const CATEGORY_ICE = 'ice';
    const CATEGORY_RJ = 'rj';

    /**
     * @var \Medoo\Medoo Database link
     */
    private $db;

    /**
     * @var Station Holds link to station manager
     */
    private $Station;

    /**
     * @var TimetableData Holds data required to generate timetable
     */
    private $tempData;

    /**
     * @var array Holds stations along the way
     */
    private $stationList;

    public function __construct(TimetableData $data)
    {
        $this->tempData = $data;

        $this->db = DatabaseFactory::getInstance();
        $this->Station = new Station($this->tempData->getRouteID());
    }

    /**
     *
     */
    public function generate()
    {
        // TODO:
        // add random delay on start to make it more real
        $randomDelay = $this->randomDelay(5);
        // for each step add time
        $startTime = $this->tempData->getStartTime();
        try {

            // collect list of stations where the train stops
            $stationList = $this->Station->getStationListByService($this->tempData->getStart(),
                $this->tempData->getFinish(), $this->tempData->getServiceCategory());
            return $stationList;
            /*
             * TODO
             *
            FOR EACH RECORD IN DATABASE TRY TO FIND FROM 1 TO 2, IF EXIST THEN FROM 2 TO 3, IF DOES NOT EXIST
            THEN FROM 1 TO 3 ETC
            die;

            $timetable[$key]['arrivalTime'] = '12:00';
            $timetable[$key]['departureTime'] = '12:01';
            $timetable[$key]['stationName'] = $value['stationName'];

            return $timetable;

            */
        } catch (StationErrorException $e) {
            echo $e->getMessage();
        }


    }

    private function randomDelay(int $about): int
    {
        return 5;
    }

    /**
     * Reads from database the time needed to drive distance with max allowed speed
     *
     * @param int $from
     * @param int $to
     * @param string $service
     * @return int positive value on success, -1 on fail
     */
    private function getTime(int $from, int $to, string $service): int
    {
        $result = $this->db->get('distances', [
            'time',
        ], [
            'AND' => [
                'fromStationID[=]' => $from,
                'toStationID[=]'   => $to,
                'serviceID[=]'     => $service,
            ],
        ]);

        if ($result['time'] > 0) {
            return $result['time'];
        } else {
            return -1;
        }
    }
}