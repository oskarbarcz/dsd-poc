<?php


namespace DBLS\Controller\Base;

use Countable;
use DBLS\Exceptions\TimetableException;
use DBLS\Model\TimetableData;

/**
 * Class TimetableSession holds Timetable session creation tools
 *
 * @package DBLS\Controller\Base
 */
class TimetableSessionCreator implements Countable
{
    /**
     * @var array Timetable held as array
     */
    private $timetable;

    private $timetableData;

    /**
     * @var bool flag set to true locks editing options
     */
    private $ready;

    /**
     * @var array array holding database record
     */
    private $unit;

    public function __construct(array $unit, TimetableData $timetableData)
    {
        $this->timetable = [];
        $this->timetableData = $timetableData;
        $this->unit = $unit;
        $this->ready = false;
    }

    /**
     * Add stop on station to timetable
     *
     * @param array $data stop details
     * @return int amount of stations already created
     * @throws TimetableException if used when object is created
     */
    public function append(array $data): int
    {
        if ($this->ready) {
            throw new TimetableException('Tried to append a value when object is fully created!', 121);
        }
        $this->timetable[] = $data;
        return count($this->timetable);
    }

    /**
     * Gets timetable as array
     *
     * @return array
     * @throws TimetableException
     */
    public function getTimetable(): array
    {
        if (!$this->ready) {
            return [];
        }
        return $this->timetable;
    }

    public function getTimetableData(): TimetableData
    {
        return $this->timetableData;
    }


    public function getAssignedUnit(): array
    {
        return $this->unit;
    }

    /**
     * Initiates session with Timetable and User infos
     *
     * @param int $userID
     * @return TimetableSession Session object
     * @throws TimetableException
     */
    public function initSession(): TimetableSession
    {
        if (!$this->ready) {
            throw new TimetableException('Timetable is not fully created!', 120);
        }
        return new TimetableSession($this);
    }

    /**
     * Locks editing of modules
     */
    public function setReady(): void
    {
        $this->ready = true;
    }

    /**
     * @return int amount of stops during the way
     */
    public function count(): int
    {
        return count($this->timetable);
    }

}