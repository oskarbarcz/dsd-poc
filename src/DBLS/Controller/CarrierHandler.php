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
        $this->_db->insert('railcompanies', [
            'companyID'       => null,
            'companyName'     => $Data->getName(),
            'companyAddress'  => $Data->getAddress(),
            'companyNIP'      => $Data->getNIP(),
            'companyREGON'    => $Data->getREGON(),
            'companyCountry'  => $Data->getUIC(),
            'companyUICcode'  => 'DBAG',
            'companyLogoPath' => $path,
            'companyActive'   => true,
        ]);
        return true;
    }

    public function getCarrierByID(int $id)
    {

    }

    public function deleteCarrierbyID(int $id)
    {
        $this->_db->delete('railcompanies', [
            'companyID' => $id,
        ]);
    }

    public function getCarriers(bool $detailed = true): array
    {
        if ($detailed) {
            $query = $this->_db->select('railcompanies', [
                'companyID',
                'companyName',
                'companyAddress',
                'companyNIP',
                'companyREGON',
                'companyCountry',
                'companyUICcode',
                'companyLogoPath',
                'companyActive',
            ]);

            if ($query) {
                return $query;
            } else return [];
        } else {
            $query = $this->_db->select('railcompanies', [
                'companyID',
                'companyName',
                'companyCountry',
            ]);

            if ($query) {
                return $query;
            } else return [];
        }
    }
}