<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 28 October 2018
 * Time: 19:55
 */

namespace DBLS\Controller;

use DBLS\Interfaces\ValidateInterface;


abstract class CRUD
{
    /**
     * Method to create an element in collection
     *
     * @param ValidateInterface $data
     * @return bool true if success, false on fail
     */
    abstract public function create(ValidateInterface $data): bool;

    /**
     * Method to read an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    abstract public function read($id): bool;

    /**
     * Method to read all elements in collection
     *
     * @return array collection of all items
     */
    abstract public function readAll(): array;

    /**
     * Method to update an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    abstract public function update(int $id): bool;

    /**
     * Method to create an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    abstract public function delete($id): bool;

}