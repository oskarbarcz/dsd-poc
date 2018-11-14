<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 14 November 2018
 * Time: 18:26
 */

namespace DBLS\Controller\Base;


use ArchFW\Model\DatabaseFactory;

class Unit
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance();
    }

    public function read(int $id): array
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

    public function readAll()
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
}