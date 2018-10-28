<?php

namespace DBLS\Controller\Maintenance;

use ArchFW\Model\DatabaseFactory;
use DBLS\Controller\CRUD;
use DBLS\Model\TrackObjectData;

/**
 * Class used to manage track objects
 *
 * @package DBLS\Controller\Maintenance
 */
class TrackObject extends CRUD
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
     * @param TrackObjectData $data
     * @return bool true if success, false on fail
     */
    public function create(TrackObjectData $data): bool
    {
        $result = $this->db->insert('trackobjects', [
            'objectID'        => null,
            'objectTypeID'    => $data->getTypeID(),
            'objectRouteID'   => $data->getRouteID(),
            'objectName'      => $data->getName(),
            'objectKilometer' => $data->getKilometer(),
        ]);
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

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