<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 31 October 2018
 * Time: 21:00
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;
use DBLS\Exceptions\StationErrorException;

/**
 * Class Station for station things
 *
 * @package DBLS\Controller\Base
 */
class Station
{
    /**
     * @var \Medoo\Medoo Database link
     */
    private $db;

    /**
     * @var integer Holds assigned route identifier
     */
    private $routeID;

    /**
     * Creates a line station manager
     *
     * @param int $routeID assinged line ID
     */
    public function __construct(int $routeID)
    {
        $this->db = DatabaseFactory::getInstance();
        $this->routeID = $routeID;
    }

    /**
     * Get all stations along the selected track
     *
     * @param int $from start station
     * @param int $to stop station
     * @return array list of stations
     * @throws StationErrorException when error occures
     */
    public function getStationList(int $from, int $to): array
    {
        // define SQL value for direction
        $order = ($to > $from) ? 'ASC' : 'DESC';

        // change order of values in between form
        $arr = ($to > $from) ? [$from, $to] : [$to, $from];

        // if user specified road between the same station
        if ($to == $from) {
            throw new StationErrorException('Departure and arrival stations are the same', 101);
        }
        // query
        $result = $this->db->select('stations', [
            'stationID',
            'routeID',
            'stationOrder',
            'stationName',
            'stationShort',
            'stationFID',
        ], [
            'routeID[=]'       => $this->routeID,
            'stationOrder[<>]' => $arr,
            'ORDER'            => ['stationOrder' => $order],
        ]);

        if (!$result) {
            throw new StationErrorException('There are no stops on this road, on selected sector.', 102);
        }

        return $result;
    }

    public function generateStopList()
    {

    }

}