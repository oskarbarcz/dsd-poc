<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 16 August 2018
 * Time: 21:21
 */

namespace DBLS\Interfaces;

use Exception;

/**
 * All classes that are incoming some data, should provide a way to validate them.
 *
 * @package PasswordManager\Controller
 */
interface IValidator
{
    /**
     * Validates fully entered data
     *
     * @return bool true if everything went OK while verifying
     * @throws Exception when given data are not valid
     */
    public function validate(): bool;
}