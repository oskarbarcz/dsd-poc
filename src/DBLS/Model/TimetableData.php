<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 1 November 2018
 * Time: 0:13
 */

namespace DBLS\Model;


class TimetableData
{
    private $start;
    private $finish;
    private $startTime;
    private $routeID;
    private $serviceCategory;

    public function __construct(int $start, int $finish, int $startTime, int $routeID, string $serviceCategory)
    {
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
     * @return int
     */
    public function getStartTime(): int
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
     * @return string
     */
    public function getServiceCategory(): string
    {
        return $this->serviceCategory;
    }
}