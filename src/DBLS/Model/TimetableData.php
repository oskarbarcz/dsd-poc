<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 1 November 2018
 * Time: 0:13
 */

namespace DBLS\Model;

use DBLS\Interfaces\ValidateInterface;

/**
 * Class TimetableData injects dependiencies to Timetable Generator
 *
 * @package DBLS\Model
 */
class TimetableData extends Data implements ValidateInterface
{
    /**
     * @var int holds ID of start station
     */
    private $start;

    /**
     * @var int holds ID of finish station
     */
    private $finish;

    /**
     * @var string holds start time in H:i format
     */
    private $startTime;

    /**
     * @var int Holds assigned routeID
     */
    private $routeID;

    /**
     * @var int Holds service category ID (eg. IC -> 1, etc)
     */
    private $serviceCategory;

    public function __construct(int $start, int $finish, string $startTime, int $routeID, int $serviceCategory)
    {
        // assign values
        $this->start = $start;
        $this->finish = $finish;
        $this->startTime = $startTime;
        $this->routeID = $routeID;
        $this->serviceCategory = $serviceCategory;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getFinish(): int
    {
        return $this->finish;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @return int
     */
    public function getRouteID(): int
    {
        return $this->routeID;
    }

    /**
     * @return int
     */
    public function getServiceCategory(): int
    {
        return $this->serviceCategory;
    }

    public function validate(): bool
    {

    }
}