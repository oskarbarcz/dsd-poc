<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 6 November 2018
 * Time: 21:24
 */

namespace DBLS\Model;


use DBLS\Exceptions\ValidateException;
use DBLS\Interfaces\ValidateInterface;
use function strlen;

/**
 * Route data dependiency injector
 *
 * @package DBLS\Model
 */
class RouteData extends Data implements ValidateInterface
{
    /**
     * @var int kursbuckstrecke
     */
    private $kbs;

    /**
     * @var int maximum speed
     */
    private $maxSpeed;

    /**
     * @var string route name
     */
    private $name;

    /**
     * @var int route length
     */
    private $length;

    /**
     * RouteData constructor.
     *
     * @param int    $kbs      kursbuckstrecke
     * @param int    $maxSpeed maximum speed
     * @param string $name     route name
     * @param int    $length   route length
     * @throws ValidateException
     */
    public function __construct(int $kbs, int $maxSpeed, string $name, int $length)
    {
        $this->kbs = $kbs;
        $this->maxSpeed = $maxSpeed;
        $this->name = $name;
        $this->length = $length;

        $this->validate();
    }

    /**
     * @return bool
     * @throws ValidateException
     */
    public function validate(): bool
    {
        if ($this->kbs < 100 or $this->kbs > 9999) {
            throw new ValidateException('KBS number must be between 100 and 9999', 100);
        } elseif ($this->maxSpeed <= 0) {
            throw new ValidateException('Cannot add a route that has max speed below or equal 0', 101);
        } elseif ($this->maxSpeed > 500) {
            throw new ValidateException('Maximum speed cannot rise about 500 km/h', 102);
        } elseif ($this->length <= 0) {
            throw new ValidateException('Cannot add a route that has lenght below or equal 0', 103);
        } elseif ($this->length > 250 * 1000/* in meters */) {
            throw new ValidateException('Cannot add a single route that has length above 250 kilometers', 104);
        } elseif (strlen($this->name) > 64) {
            throw new ValidateException('Maximum signs count in name is 64', 105);
        } else {
            return true;
        }
    }

    /**
     * @return int kursbuckstrecke
     */
    public function getKbs(): int
    {
        return $this->kbs;
    }

    /**
     * @return int  maximum speed
     */
    public function getMaxSpeed(): int
    {
        return $this->maxSpeed;
    }

    /**
     * @return string  route name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int  route length
     */
    public function getLength(): int
    {
        return $this->length;
    }
}