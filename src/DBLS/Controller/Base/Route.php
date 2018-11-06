<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 6 November 2018
 * Time: 18:42
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;
use DBLS\Interfaces\PresenceInterface;

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