<?php
/**
 * Created by PhpStorm.
 * Account: konta
 * Date: 15 August 2018
 * Time: 12:53
 */

namespace DBLS\Controller;

use ArchFW\Model\Database;
use ArchFW\Model\DatabaseFactory;
use DBLS\Model\LoginData;
use DBLS\Model\RegisterData;
use DBLS\Model\RestorePasswordData;

/**
 * Instantiate this class to log user and manage them. Use static methods to recover access to an account or create
 * new one.
 *
 * @package PasswordManager\Controller\Account
 */
class User
{

    /**
     * @var string Holds user login from object given in constructor. Warning! Value is emptyied while succesful
     * logging user!
     */
    protected $_userLogin;

    /**
     * @var string Holds user password from object given in constructor. Warning! Value is emptyied while succesful
     * logging user!
     */
    protected $_userPassword;

    /**
     * @var bool Holds flag about being logged
     */
    protected $_isLogged;

    /**
     * @var Database Holds Database connection
     */
    protected $_db;

    /**
     * @var array Holds details about user
     */
    protected $_userData;

    #region Instance methods

    /**
     * Account constructor.
     *
     * @param LoginData $Data
     */
    public function __construct(LoginData $Data)
    {
        $this->_isLogged = false;

        // set database connection
        $this->_db = DatabaseFactory::getInstance();

        $this->_userLogin = $Data->getLogin();
        $this->_userPassword = $Data->getPassword();
    }

    /**
     * Registers user with RegisterData object. Before addition, checks if user does not exists in database actually
     *
     * @param RegisterData $Data
     * @return bool true if user were created, false if user existed with the same email or login
     */
    public static function registerUser(RegisterData $Data): bool
    {
        if (self::_checkUserExist($Data->getLogin(), $Data->getEmail())) {
            return false;
        }

        // set database connection
        $db = DatabaseFactory::getInstance();

        // executing add query
        $db->insert('accounts', [
            'accountID'     => null,
            'name'          => $Data->getName(),
            'surname'       => $Data->getSurname(),
            'login'         => $Data->getLogin(),
            'password'      => hash('sha256', $Data->getPassword()),
            'email'         => $Data->getEmail(),
            'active'        => true,
            'lastLoginTime' => null,
            'registerTime'  => date('Y-m-d H:i:s'),
        ]);
        return true;

    }

    /**
     * Checks if user with given login or e-mail exists in database
     *
     * @param $login
     * @param $email
     * @return bool returns true when user exists, false if not
     */
    protected static function _checkUserExist($login, $email): bool
    {
        // creating database connector
        $db = DatabaseFactory::getInstance();

        // query
        $data = $db->select('accounts', [
            'accountID',
        ], [
            'OR' => [
                'accountLogin[=]'    => $login,
                'accountPassword[=]' => $email,
            ],
        ]);

        // empty array resolves to false
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public static function recoverPassword(RestorePasswordData $Password)
    {

    }

    /**
     * Log user with its login or e-mail and password
     *
     * @return boolean is login successful
     */
    public function logUser(): bool
    {
        if ($this->_isLogged) {
            return true;
        }

        // database query
        $data = $this->_db->select('accounts', [
            '[>]railcompanies' => [
                'companyID' => 'companyID',
            ],
        ], [
            'account' => [
                'accountID',
                'accountName',
                'accountSurname',
                'accountLogin',
                'accountEmail',
                'accountActive',
                'accountLastLoginTime',
                'accountRegisterTime',
            ],
            'company' => [
                'railcompanies.companyID',
                'railcompanies.companyName',
                'accounts.accountWorkStatus',
            ],
        ], [
            'AND' => [
                'OR'                          => [
                    'accounts.accountLogin[=]' => $this->_userLogin,
                    'accounts.accountEmail[=]' => $this->_userLogin,
                ],
                'accounts.accountPassword[=]' => $this->_userPassword,
                'accounts.accountActive[=]'   => true,
            ],
        ]);

        // empty array evaluates to false
        if ($data) {
            $this->_isLogged = true;

            // set new last login time in database
            $this->_updateLLT($data[0]['account']['accountID']);

            // setting user details as class property
            $this->_userData = $data[0];

            // freeing memory from unnessesary stuff
            $this->_userLogin = null;
            $this->_userPassword = null;
            return true;
        } else {
            $this->_isLogged = false;
            return false;
        }
    }

    /**
     * Updates logged user last login time
     *
     * @param integer $id logged user ID
     */
    protected function _updateLLT($id): void
    {
        $date = date('Y-m-d H:i:s');

        $this->_db->update('accounts', [
            'accountLastLoginTime' => $date,
        ], [
            'accountID[=]' => $id,
        ]);
    }

#endregion
#region Static methods

    /**
     * Check if database with user data works correctly
     *
     * @return bool true if exist, false if not
     */
    public function isDatabaseConnection(): bool
    {
        if ($this->_db) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns true if user is logged, false if not, null if user s not created
     *
     * @return boolean|null
     */
    public function isLogged()
    {
        return $this->_isLogged;
    }

    /**
     * Returns array with user details
     *
     * @return array
     */
    public function getUserData()
    {
        return $this->_userData;
    }

#endregion
#region Magic methods

    public function __sleep()
    {
        return [
            '_userData',
            '_isLogged',
        ];
    }

    public function __wakeup()
    {
        $this->_db = DatabaseFactory::getInstance();
    }


#endregion
}