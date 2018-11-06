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

    public function __construct(int $start, int $finish, string $startTime, int $routeID, int $serviceCategory)
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
}