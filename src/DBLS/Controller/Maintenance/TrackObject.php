<?php

namespace DBLS\Controller\Maintenance;

use ArchFW\Model\DatabaseFactory;
use DBLS\Interfaces\CRUDInterface;
use DBLS\Interfaces\ValidateInterface;

/**
 * Class used to manage track objects
 *
 * @package DBLS\Controller\Maintenance
 */
class TrackObject implements CRUDInterface
{
    /**
     * @var \Medoo\Medoo Database holder
     */
    private $db;

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance();
    }

    /**
     * Method to create an element in collection
     *
     * @param ValidateInterface $data
     * @return bool true if success, false on fail
     */
    public function create(ValidateInterface $data): bool
    {

    }

    /**
     * Method to read an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    public function read($id): bool
    {
        // TODO: Implement read() method.
    }

    /**
     * Method to read all elements in collection
     *
     * @return array collection of all items
     */
    public function readAll(): array
    {
        // TODO: Implement readAll() method.
        return [];
    }

    /**
     * Method to update an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    public function update(int $id): bool
    {
        // TODO: Implement update() method.
    }

    /**
     * Method to create an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    public function delete($id): bool
    {
        // TODO: Implement delete() method.
    }
}