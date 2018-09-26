<?php
/**
 * Created by PhpStorm.
 * Account: konta
 * Date: 15 August 2018
 * Time: 19:08
 */

namespace DBLS\Model;

use Exception;
use PasswordManager\Interfaces\IValidator;

/**
 * Dependiency injection obiect for creating new user
 *
 * @package PasswordManager\Model
 */
class RegisterData extends Data implements IValidator
{

    /**
     * @var string Holds new user's name
     */
    private $name;

    /**
     * @var string Holds new user's surname
     */
    private $surname;

    /**
     * @var string Holds new user's login
     */
    private $login;
    /**
     * @var string Holds new user's password - first attempt
     */
    private $password1;

    /**
     * @var string Holds new user's password - second attempt
     */
    private $password2;

    /**
     * @var string Holds new user's e-mail
     */
    private $email;

    /**
     * Assigning values as properties and validate them.
     *
     * @param string $name user entered name
     * @param string $surname user entered surname
     * @param string $login user entered login
     * @param string $password1 user password (first attempt)
     * @param string $password2 user password (second attempt)
     * @param string $email user e-mail
     * @throws Exception when password is not valid
     */
    public function __construct($name, $surname, $login, $password1, $password2, $email)
    {
        // assign values
        $this->name = $name;
        $this->surname = $surname;
        $this->login = $login;
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->email = $email;

        // validate them
        $this->validate();
    }

    /**
     * Validates fully entered data
     *
     * @return bool true if everything went OK while verifying
     * @throws Exception when given data are not valid
     */
    public function validate(): bool
    {
        // validate through all steps will make sure that user has entered everything correctly
        if ((strlen($this->login) < 5) or (strlen($this->login) > 16)) {
            // step #1 - verify login, login must be between 5 and 16 characters
            throw new Exception("Login must be between 5 and 16 characters length.", 601);
        } else if ((strlen($this->name) < 2) or (strlen($this->name) > 32)) {
            // step #2 - verify name, name must be between 2 and 32 characters
            throw new Exception("Account name must be between 2 and 32 characters length.", 602);
        } else if ((strlen($this->surname) < 2) or (strlen($this->surname) > 32)) {
            // step #3 - verify surname, surname must be between 2 and 32 characters
            throw new Exception("Account surname must be between 2 and 32 characters length.", 603);
        } else if ($this->password1 !== $this->password2) {
            // step #4 - verify passwords, passwords must be the same
            throw new Exception("Both passwords must be the same.", 604);
        } else if ((strlen($this->password1) < 8) or !$this->_checkComplexity($this->password1)) {
            // step #5 - verify password complexity
            throw new Exception("Passwords are not complex enough.", 605);
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            // step #6 - verify e-mail structure
            throw new Exception("E-mail has no valid format.", 606);
        } else {
            return true;
        }


    }

    /**
     * Function returns true when given password is valid and complex.
     *
     * Requirements: At least one big letter, at least one small letter, and at least one number
     *
     * @param $password
     * @return bool
     */
    private function _checkComplexity($password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if (!$uppercase || !$lowercase || !$number) {
            return false;
        } else return true;

    }

    /**
     * @return string Holds new user's login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string Holds new user's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string Holds new user's surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string Holds new user's password
     */
    public function getPassword()
    {
        return $this->password1;
    }

    /**
     * @return string Holds new user's e-mail
     */
    public function getEmail()
    {
        return $this->email;
    }
}