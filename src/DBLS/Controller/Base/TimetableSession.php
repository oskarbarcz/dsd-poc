<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 12 November 2018
 * Time: 21:14
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;

/**
 * Class TimetableSession
 *
 * OBJECT HAS TO BE STORED IN SESSION
 *
 * @package DBLS\Controller\Base
 */
class TimetableSession
{
    private $db;

    private $times;

    /**
     * @var array array holding database record
     */
    private $unit;

    private $timetableData;

    private $allStops;

    private $actualStationIndex;

    public function __construct(TimetableSessionCreator $Timetable)
    {
        // creating database link
        $this->db = DatabaseFactory::getInstance();


        // assing timetable values
        $this->times = $Timetable->getTimetable();
        $this->timetableData = $Timetable->getTimetableData();

        $this->unit = $Timetable->getAssignedUnit();
        $this->allStops = count($Timetable);
        $this->init($this->unit['unitID']);

        $this->actualStationIndex = 0;
    }

    /**
     * Function returns an array with all session details, such as limits and next stations
     *
     * @return array
     */
    public function getCurrent(): array
    {
        return [
            'limitStations' => [
                'first' => [
                    'departure'   => $this->times[0]['departureTime'],
                    'stationName' => $this->times[0]['stationName'],
                ],
                'last'  => [
                    'departure'   => $this->times[$this->allStops - 1]['arriveTime'],
                    'stationName' => $this->times[$this->allStops - 1]['stationName'],
                ],
            ],
            'actualStation' => $this->times[$this->actualStationIndex],
            'nextStation'   => $this->times[$this->actualStationIndex + 1],
        ];
    }

    /**
     * Return timetable built by TimetableGenerator for route with parameters
     *
     * @return array
     */
    public function getTimetable()
    {
        return $this->times;
    }

    public function next(): void
    {
        $this->actualStationIndex++;
    }

    /**
     * Initiates session in database
     *
     * @param int $accountID
     * @return int SessionID
     */
    private function init(int $accountID): int
    {
        // TODO: check account existance

        $this->db->insert('drivesessions', [
            'driveSessionID' => null,
            'accountID'      => $accountID,
            'routeID'        => $this->timetableData->getRouteID(),
            'unitID'         => $this->unit['unitID'],
            'unitSideNumber' => '344',
            'serviceID'      => $this->timetableData->getServiceCategory(),
            'name'           => '',
            'number'         => '',
            'createDate'     => \date(MYSQLI_DATETIME),
            'startTime'      => $this->timetableData->getStartTime(),

        ]);

        return 200;

    }

    /**
     * Delete database link on serialization
     *
     * @return array
     */
    public function __sleep(): array
    {
        return ['db'];
    }

    /**
     * On deseralisation create new database link
     */
    public function __wakeup()
    {
        $this->db = DatabaseFactory::getInstance();
    }
}