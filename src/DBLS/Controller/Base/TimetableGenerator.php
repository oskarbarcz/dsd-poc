<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 24 September 2018
 * Time: 20:00
 */

namespace DBLS\Controller;


use ArchFW\Model\DatabaseFactory;
use DBLS\Controller\Base\Station;

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
     * @var array Holds stations along the way
     */
    private $stationList;

    public function __construct(int $start, int $finish, int $routeID, string $serviceCategory)
    {
        $this->db = DatabaseFactory::getInstance();
        $this->Station = new Station($routeID);
        $this->stationList = $this->Station->getStationListByRoute($start, $finish);
    }
}