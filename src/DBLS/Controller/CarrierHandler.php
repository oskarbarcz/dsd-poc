<?php

namespace DBLS\Controller;


use ArchFW\Model\DatabaseFactory;
use DBLS\Model\NewCarrierData;

class CarrierHandler
{
    private $_db;

    public function __construct()
    {
        $this->_db = DatabaseFactory::getInstance();
    }

    public function addCarrier(NewCarrierData $Data, $path): bool
    {
        $this->_db->insert('carriers', [
            'carrierID'       => null,
            'carrierName'     => $Data->getName(),
            'carrierAddress'  => $Data->getAddress(),
            'carrierNIP'      => $Data->getNIP(),
            'carrierREGON'    => $Data->getREGON(),
            'carrierCountry'  => $Data->getUIC(),
            'carrierUICcode'  => 'DBAG',
            'carrierLogoPath' => $path,
            'carrierActive'   => true,
        ]);
        return true;
    }

    public function getCarrierByID(int $id)
    {

    }

    public function deleteCarrierbyID(int $id)
    {
        $this->_db->delete('carriers', [
            'carrierID' => $id,
        ]);
    }

    public function getCarriers(bool $detailed = true): array
    {
        if ($detailed) {
            $query = $this->_db->select('carriers', [
                'carrierID',
                'carrierName',
                'carrierAddress',
                'carrierNIP',
                'carrierREGON',
                'carrierCountry',
                'carrierUICcode',
                'carrierLogoPath',
                'carrierActive',
            ]);

            if ($query) {
                return $query;
            } else return [];
        } else {
            $query = $this->_db->select('carriers', [
                'carrierID',
                'carrierName',
                'carrierCountry',
            ]);

            if ($query) {
                return $query;
            } else return [];
        }
    }
}