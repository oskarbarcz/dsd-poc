<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 31 October 2018
 * Time: 21:00
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;

class Station
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance();
    }

    /**
     * Get all stations along the selected track
     *
     * @param string $routeID ID of track
     * @param bool $direction ascending or descendig (perimeterly)
     * @return array list of stations
     */
    public function getStationListByRoute(string $routeID, bool $direction): array
    {
        $order = ($direction) ? 'ASC' : 'DESC';

        $result = $this->db->select('stations', [
            'stationID',
            'routeID',
            'stationOrder',
            'stationName',
            'stationShort',
            'stationFID',
        ], [
            'routeID[=]' => $routeID,
            'ORDER'      => [
                'stationOrder' => $order,
            ],
        ]);

        return $result;
    }

}