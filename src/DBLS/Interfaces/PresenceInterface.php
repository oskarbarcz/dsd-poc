<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 6 November 2018
 * Time: 18:43
 */

namespace DBLS\Interfaces;

/**
 * Interface PresenceInterface implements methods used to
 *
 * @package DBLS\Interfaces
 */
interface PresenceInterface
{
    /**
     * Checks if database has representation of element with given ID
     *
     * @param int $id id of element
     * @return bool true if has, false if hasn't
     */
    public function has(int $id): bool;
}