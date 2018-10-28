<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 28 October 2018
 * Time: 19:55
 */

namespace DBLS\Controller\Maintenance;


use ArchFW\Model\DatabaseFactory;
use DBLS\Controller\CRUD;
use DBLS\Interfaces\ValidateInterface;

class TrackObjectCategory extends CRUD
{
    /**
     * @var \Medoo\Medoo Holds database link
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
        // TODO: Implement create() method.
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
        return $this->db->select('objecttypes', [
            'objectTypeID',
            'objectTypeName',
            'objecTypeCSS',
        ]);
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