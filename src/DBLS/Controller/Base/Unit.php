<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 14 November 2018
 * Time: 18:26
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;
use DBLS\Exceptions\ElementNotFoundException;
use DBLS\Interfaces\PresenceInterface;

class Unit implements PresenceInterface
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance();
    }

    /**
     * @param int $id
     * @return array
     * @throws ElementNotFoundException when ID not found
     */
    public function read(int $id): array
    {
        // catch the lack of ID in database
        if (!$this->has($id)) {
            throw new ElementNotFoundException('Element not found', 100);
        }

        // query
        $result = $this->db->select('units', [
            'unitID',
            'carrierID',
            'type',
            'name',
            'length',
            'weight',
            'maxSpeed',
            'producer',
            'powerType',
            'accRatio',
        ], [
            'unitID[=]' => $id,
        ]);

        // check if result exists
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    public function readAll(): array
    {
        // query
        $result = $this->db->select('units', [
            'unitID',
            'carrierID',
            'type',
            'name',
            'length',
            'weight',
            'maxSpeed',
            'producer',
            'powerType',
            'accRadio',
        ]);

        // check if result exists
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    public function has(int $id): bool
    {
        return $this->db->has('units', [
            'unitID[=]' => $id,
        ]);
    }
}