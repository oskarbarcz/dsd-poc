<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 28 October 2018
 * Time: 19:55
 */

namespace DBLS\Controller;


abstract class CRUD
{
    /**
     * Method to read an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    abstract public function read(int $id): bool;

    /**
     * Method to read all elements in collection
     *
     * @return array collection of all items
     */
    abstract public function readAll(): array;

    /**
     * Method to create an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    abstract public function delete(int $id): bool;

}