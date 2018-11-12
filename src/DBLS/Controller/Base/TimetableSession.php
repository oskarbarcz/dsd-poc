<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 12 November 2018
 * Time: 21:14
 */

namespace DBLS\Controller\Base;


class TimetableSession
{

    private $times;

    private $allStops;

    private $actualStationIndex;

    public function __construct(TimetableSessionCreator $Timetable)
    {
        // assing timetable values
        $this->times = $Timetable->getTimetable();
        $this->allStops = count($Timetable);

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
}