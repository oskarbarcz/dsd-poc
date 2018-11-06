<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 6 November 2018
 * Time: 18:42
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;
use DBLS\Exceptions\ElementNotFoundException;
use DBLS\Interfaces\PresenceInterface;
use DBLS\Model\RouteData;

/**
 * Route related stuff
 *
 * @package DBLS\Controller\Base
 */
class Route implements PresenceInterface
{
    /**
     * @var \Medoo\Medoo
     */
    private $db;

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance();
    }

    /**
     * Create new route
     *
     * @param RouteData $Data
     * @return bool
     */
    public function create(RouteData $Data)
    {
        $result = $this->db->insert('routes', [
            'routeID'  => null,
            'kbs'      => $Data->getKbs(),
            'maxSpeed' => $Data->getMaxSpeed(),
            'fullName' => $Data->getName(),
            'length'   => $Data->getLength(),
            'active'   => true,
        ]);

        // return true if rows affected
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get route details with ID
     *
     * @param int $id
     * @return array
     * @throws ElementNotFoundException
     */
    public function read(int $id): array
    {
        if (!$this->has($id)) {
            throw new ElementNotFoundException("Element with ID [{$id}] were not found", 100);
        }

        return $this->db->get('routes', [
            'routeID',
            'kbs',
            'maxSpeed',
            'fullName',
            'length',
            'active',
        ], [
            'routeID[=]' => $id,
        ]);
    }

    /**
     * Get all routes details
     *
     * @return array
     */
    public function readAll(): array
    {
        return $this->db->select('routes', [
            'routeID',
            'kbs',
            'maxSpeed',
            'fullName',
            'length',
            'active',
        ]);
    }

    /**
     * Update route data
     *
     * @param int $id
     * @param RouteData $Data
     * @return bool
     * @throws ElementNotFoundException
     */
    public function update(int $id, RouteData $Data): bool
    {
        if (!$this->has($id)) {
            throw new ElementNotFoundException("Element with ID [{$id}] were not found", 100);
        }

        $result = $this->db->update('routes', [
            'kbs'      => $Data->getKbs(),
            'maxSpeed' => $Data->getMaxSpeed(),
            'fullName' => $Data->getName(),
            'length'   => $Data->getLength(),
        ], [
            'routeID[=]' => $id,
        ]);
        // return true if rows affected
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete route with selected ID
     *
     * @param int $id
     * @return bool
     * @throws ElementNotFoundException
     */
    public function delete(int $id): bool
    {
        if (!$this->has($id)) {
            throw new ElementNotFoundException("Element with ID [{$id}] were not found", 100);
        }

        $result = $this->db->delete('routes', [
            'routeID[=]' => $id,
        ]);
        // return true if rows affected
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if route with given ID exists
     *
     * @param int $id id of element
     * @return bool true if has, false if hasn't
     */
    public function has(int $id): bool
    {
        return $this->db->has('routes', [
            'routeID[=]' => $id,
        ]);
    }
}