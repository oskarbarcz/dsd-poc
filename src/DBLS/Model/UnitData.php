<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 14 November 2018
 * Time: 18:25
 */

namespace DBLS\Model;

use DBLS\Exceptions\ValidateException;
use DBLS\Interfaces\ValidateInterface;

class UnitData extends Data implements ValidateInterface
{

    /**
     * Consts defining power type
     */
    const POWER_TYPE_DIESEL = 'diesel';
    const POWER_TYPE_ELECTRIC = 'electric';
    const POWER_TYPE_STEAM = 'steam';

    /**
     * Consts defining train types
     */
    const TRAIN_TYPE_LOC_ONLY = 'locomotive-only';
    const TRAIN_TYPE_AGGL = 'agglomeration';
    const TRAIN_TYPE_REGIO = 'regional';
    const TRAIN_TYPE_INTERCITY = 'intercity';
    const TRAIN_TYPE_CARGO_LIGHT = 'cargo-light';
    const TRAIN_TYPE_CARGO_HEAVY = 'cargo-heavy';

    /**
     * @var int assigned carrier ID
     */
    private $carrierID;

    /**
     * @var string train appliance
     */
    private $type;

    /**
     * @var string train own name
     */
    private $name;

    /**
     * @var int train length in centimeters
     */
    private $length;

    /**
     * @var int train set weight in kilograms
     */
    private $weight;

    /**
     * @var int maximum allowed speed in kilometers per hour
     */
    private $maxSpeed;

    /**
     * @var string train set producer
     */
    private $producer;

    /**
     * @var string train set power type
     */
    private $powerType;

    /**
     * @var float acceleration ratio multiplier
     */
    private $accRatio;

    /**
     * UnitData constructor.
     *
     * @param int $carrierID assigned carrier ID
     * @param string $type train appliance
     * @param string $name train own name
     * @param int $length rain length in centimeters
     * @param int $weight train set weight in kilograms
     * @param int $maxSpeed maximum allowed speed in kilometers per hour
     * @param string $producer train set producer
     * @param string $powerType train set power type
     * @param float $accRatio acceleration ratio multiplier
     * @throws ValidateException when validation went wrong
     */
    public function __construct(
        int $carrierID,
        string $type,
        string $name,
        int $length,
        int $weight,
        int $maxSpeed,
        string $producer,
        string $powerType,
        float $accRatio
    ) {

        // assign values
        $this->carrierID = $carrierID;
        $this->type = $type;
        $this->name = $name;
        $this->length = $length;
        $this->weight = $weight;
        $this->maxSpeed = $maxSpeed;
        $this->producer = $producer;
        $this->powerType = $powerType;
        $this->accRatio = $accRatio;

        // run validation
        $this->validate();
    }

    public function validate(): bool
    {
        if ($this->type !== self::TRAIN_TYPE_AGGL or $this->type !== self::TRAIN_TYPE_REGIO or $this->type !== self::TRAIN_TYPE_INTERCITY or $this->type !== self::TRAIN_TYPE_CARGO_LIGHT or $this->type !== self::TRAIN_TYPE_CARGO_HEAVY or $this->type !== self::TRAIN_TYPE_AGGL or $this->type !== self::TRAIN_TYPE_LOC_ONLY) {
            throw new ValidateException('Train type is not any known train category', 100);
        } elseif (strlen($this->name) > 128) {
            throw new ValidateException('Specified name is too long', 101);
        } elseif ($this->length < 500) {
            throw new ValidateException('Train set cannot be shorter than 5 meters (500 cm)', 101);
        } elseif ($this->length > 360000) {
            throw new ValidateException('Train set cannot be longer than 3600 meters (3600000 cm)', 101);
        } elseif ($this->weight < 500) {
            throw new ValidateException('Train set cannot be lighter than 500 kilograms', 101);
        } elseif ($this->weight > 6000000) {
            throw new ValidateException('Train set cannot be heavier than 6000 tons (6000000 kilograms)', 101);
        } elseif ($this->maxSpeed < 20) {
            throw new ValidateException('Train set cannot have maximum speed below 20 km/h', 101);
        } elseif ($this->maxSpeed > 320) {
            throw new ValidateException('Train set cannot have maximum speed over 320 km/h', 101);
        } elseif (strlen($this->producer) > 64) {
            throw new ValidateException('Train producer name cannot be longer than 64 chars', 101);
        } elseif ($this->powerType !== self::POWER_TYPE_DIESEL or $this->powerType !== self::POWER_TYPE_ELECTRIC or $this->powerType !== self::POWER_TYPE_STEAM) {
            throw new ValidateException('Unknown train power system', 101);
        } elseif ($this->accRatio > 3.0) {
            throw new ValidateException('Train acceleration ratio cannot be higher than 3.0', 101);
        } elseif ($this->accRatio < 0.3) {
            throw new ValidateException('Train acceleration ratio cannot be lower than 0.3', 101);
        } else {
            return true;
        }
    }
}