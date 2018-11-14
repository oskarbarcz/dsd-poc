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
use DBLS\Exceptions\TimetableException;
use DBLS\Model\TimetableData;

/**
 * Class that generates timetable
 *
 * @package DBLS\Controller
 */
class TimetableGenerator
{

    const TIME_ON_STOP_IC = 2;

    /**
     * @var \Medoo\Medoo Database link
     */
    private $db;

    /**
     * @var Station Holds link to station manager
     */
    private $Station;

    /**
     * @var array array holding database record
     */
    private $unit;

    /**
     * @var TimetableData Holds data required to generate timetable
     */
    private $tempData;

    public function __construct(TimetableData $data, int $unitID)
    {
        // assign values
        $this->tempData = $data;

        // create database link
        $this->db = DatabaseFactory::getInstance();
        $this->Station = new Station($this->tempData->getRouteID());

        $Unit = new Unit();

        $this->unit = $Unit->read($unitID);
    }

    /**
     * Generates fully-built timetable
     *
     * @return TimetableSession fully built timetable
     * @throws TimetableException
     */
    public function getSession(): TimetableSessionCreator
    {
        // for each step add time
        $startTime = strtotime($this->tempData->getStartTime());
        try {

            // collect list of stations where the train stops
            $stationList = $this->Station->getStationListByService($this->tempData->getStart(),
                $this->tempData->getFinish(), $this->tempData->getServiceCategory());

            // initiate an timetable
            $Timetable = new TimetableSessionCreator();

            $arrivalTime = date('H:i', $startTime);
            $departureTimeDelta = $startTime + 4 * 60;

            // set start station details
            $Timetable->append([
                'arriveTime'    => $arrivalTime,
                'departureTime' => $timetable[0]['departureTime'] = date('H:i', $departureTimeDelta),
                'stationName'   => $stationList[0]['stationName'],
            ]);

            for ($iterator = 0; $iterator < count($stationList) - 1; $iterator++) {
                // on each iteration add each station details
                $Timetable->append([
                    'arriveTime'    => date("H:i",
                        $departureTimeDelta += $time = $this->getTime($stationList[$iterator]['stationID'],
                            $stationList[$iterator + 1]['stationID'])),
                    'departureTime' => date("H:i", $departureTimeDelta += $this->countStopTime()),
                    'stationName'   => $stationList[$iterator + 1]['stationName'],
                ]);
            }

            $Timetable->setReady();
            return $Timetable;
        } catch (StationErrorException $e) {
            echo $e->getMessage();
        }
        // in case something broken
        return null;
    }

    /**
     * Determine stop on station time by train category
     *
     * @return int time in seconds
     */
    private function countStopTime(): int
    {
        switch ($this->tempData->getServiceCategory()) {
            // InterCity
            case 1:
                return self::TIME_ON_STOP_IC * 60;
            default:
                return 30;
        }


    }

    /**
     * Reads from database the time needed to drive distance with max allowed speed
     *
     * @param int $from
     * @param int $to
     * @return int positive value on success, -1 on fail, time in seconds
     */
    private function getTime(int $from, int $to): int
    {
        $result = $this->db->get('distances', [
            'time',
        ], [
            'AND' => [
                'fromStationID[=]' => $from,
                'toStationID[=]'   => $to,
                'serviceID[=]'     => $this->tempData->getServiceCategory(),
            ],
        ]);
        if ($result['time'] > 0) {
            // return value in seconds
            return $result['time'] * 60;
        } else {
            return -1;
        }
    }
}