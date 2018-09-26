<?php
/**
 * Created by PhpStorm.
 * Account: konta
 * Date: 15 August 2018
 * Time: 12:56
 */

namespace DBLS\Model;

/**
 * Class LoginData
 *
 * @package PasswordManager\Controller\Account
 */
class LoginData
{

    /**
     * @var string Holds login information
     */
    private $_login;

    /**
     * @var string Holds hashed password information
     */
    private $_password;

    /**
     * LoginData constructor.
     *
     * @param string $login
     * @param string $password
     * @param bool $isHashed
     */
    public function __construct(string $login, string $password, bool $isHashed)
    {
        $this->_login = $login;

        if ($isHashed) {
            $this->_password = $password;
        } else {
            $this->_password = hash('sha256', $password);
        }
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->_login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }
}