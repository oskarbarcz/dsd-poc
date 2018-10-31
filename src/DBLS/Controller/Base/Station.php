<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 31 October 2018
 * Time: 21:00
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;

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

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance();
    }

    /**
     * Get all stations along the selected track
     *
     * @param string $routeID ID of track
     * @param int $from start station
     * @param int $to stop station
     * @return array list of stations
     */
    public function getStationListByRoute(string $routeID, int $from, int $to): array
    {
        // define SQL value for direction
        $order = ($to > $from) ? 'ASC' : 'DESC';

        // change order of values in between form
        $arr = ($to > $from) ? [$from, $to] : [$to, $from];

        // if user specified road between the same station
        if ($to == $from) {
            return [];
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
            'routeID[=]'       => $routeID,
            'stationOrder[<>]' => $arr,
            'ORDER'            => ['stationOrder' => $order],
        ]);

        return $result;
    }

}