<?php

namespace DBLS\Model;

use DBLS\Interfaces\IValidator;
use Exception;

class NewCarrierData extends Data implements IValidator
{
    private $name;
    private $address;
    private $nip;
    private $regon;
    private $uic;

    /**
     * NewCarrierData constructor assigns data to object fields
     *
     * @param string $name new carrier name
     * @param string $address new carrier adress
     * @param int $nip new carrier government work id
     * @param float $regon new carrier limitation id
     * @param string $uic new carrier country
     *
     * @throws \Exception when at least one data is not correct
     */
    public function __construct(string $name, string $address, int $nip, float $regon, string $uic)
    {
        $this->name = $name;
        $this->address = $address;
        $this->nip = $nip;
        $this->regon = $regon;
        $this->uic = $uic;

        $this->validate();
    }

    public function validate(): bool
    {
        // If carrier name exceeds 32 characters
        if (strlen($this->name) > 64) {
            throw new Exception('Carrier name too long', 100);
        } else if (strlen($this->address) > 128) {
            throw new Exception('Carrier adress too long', 101);
        } else if (strlen($this->nip) !== 10) {
            throw new Exception('NIP has not correct length', 102);
        } else if (strlen($this->regon) !== 14) {
            throw new Exception('REGON has not correct length', 103);
        } else if (strlen($this->uic) !== 2) {
            throw new Exception('UIC code has not correct length', 104);
        } else return true;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getNIP(): int
    {
        return $this->nip;
    }

    /**
     * @return float
     */
    public function getREGON(): float
    {
        return $this->regon;
    }

    /**
     * @return string
     */
    public function getUIC(): string
    {
        return $this->uic;
    }
}