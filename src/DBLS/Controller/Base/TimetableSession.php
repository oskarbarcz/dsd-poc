<?php


namespace DBLS\Controller\Base;

use Countable;
use DBLS\Exceptions\TimetableException;

/**
 * Class TimetableSession holds Timetable session tools
 *
 * @package DBLS\Controller\Base
 */
class TimetableSession implements Countable
{
    /**
     * @var array Timetable held as array
     */
    private $timetable;

    /**
     * @var bool flag set to true locks editing options
     */
    private $ready;

    public function __construct($timetableID)
    {
        $this->timetable = [];
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
     * @return array
     * @throws TimetableException
     */
    public function getTimetable(): array
    {
        if (!$this->ready) {
            throw new TimetableException('Timetable is not fully created!', 120);
        }
        return $this->timetable;
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