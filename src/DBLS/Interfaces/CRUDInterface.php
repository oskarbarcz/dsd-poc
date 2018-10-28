<?php

namespace DBLS\Interfaces;

/**
 * Interface CRUDInterface contains methods for creating, reading, updating ad deleting items in api or any other
 * possible sources. Use this interface to make sure that elements has this key methods.
 *
 * @package DBLS\Interfaces
 */
interface CRUDInterface
{
    /**
     * Method to create an element in collection
     *
     * @param ValidateInterface $data
     * @return bool true if success, false on fail
     */
    public function create(ValidateInterface $data): bool;

    /**
     * Method to read an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    public function read($id): bool;

    /**
     * Method to read all elements in collection
     *
     * @return array collection of all items
     */
    public function readAll(): array;

    /**
     * Method to update an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    public function update(int $id): bool;

    /**
     * Method to create an element in collection
     *
     * @param integer $id
     * @return bool true if success, false on fail
     */
    public function delete($id): bool;
}