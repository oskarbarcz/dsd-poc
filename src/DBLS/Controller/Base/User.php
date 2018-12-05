<?php

namespace DBLS\Controller\Base;

use ArchFW\Model\DatabaseFactory;
use DBLS\Model\LoginData;
use DBLS\Model\RegisterData;
use DBLS\Model\RestorePasswordData;
use Medoo\Medoo;
use function date;
use function hash;

/**
 * Instantiate this class to log user and manage them.
 * Use static methods to recover access to an account or create
 * new one.
 *
 * @package PasswordManager\Controller\Account
 */
class User
{

    /**
     * @var string Holds user login from object given in constructor.
     * Warning! Value is emptyied while succesful
     * logging user!
     */
    protected $userLogin;

    /**
     * @var string Holds user password from object given in constructor. Warning! Value is emptyied while succesful
     * logging user!
     */
    protected $userPassword;

    /**
     * @var bool Holds flag about being logged
     */
    protected $isLogged;

    /**
     * @var Medoo Holds Database connection
     */
    protected $database;

    /**
     * @var array Holds details about user
     */
    protected $userData;

    #region Instance methods

    /**
     * Account constructor.
     *
     * @param LoginData $data
     */
    public function __construct(LoginData $data)
    {
        $this->isLogged = false;

        // set database connection
        $this->database = DatabaseFactory::getInstance();

        $this->userLogin = $data->getLogin();
        $this->userPassword = $data->getPassword();
    }

    /**
     * Registers user with RegisterData object. Before addition, checks if user does not exists in database actually
     *
     * @param RegisterData $data
     * @return bool true if user were created, false if user existed with the same email or login
     */
    public static function registerUser(RegisterData $data): bool
    {
        if (self::checkUserExist($data->getLogin(), $data->getEmail())) {
            return false;
        }

        // set database connection
        $database = DatabaseFactory::getInstance();

        // executing add query
        $database->insert('accounts', [
            'accountID'     => null,
            'name'          => $data->getName(),
            'surname'       => $data->getSurname(),
            'login'         => $data->getLogin(),
            'password'      => hash('sha256', $data->getPassword()),
            'email'         => $data->getEmail(),
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
    protected static function checkUserExist($login, $email): bool
    {
        // creating database connector
        $database = DatabaseFactory::getInstance();

        // query
        $data = $database->select('accounts', [
            'accountID',
        ], [
            'OR' => [
                'accountLogin[=]'    => $login,
                'accountPassword[=]' => $email,
            ],
        ]);

        // empty array resolves to false
        return $data ? true : false;
    }

    /**
     * @param RestorePasswordData $Password
     */
    public static function recoverPassword(/*RestorePasswordData $Password*/)
    {
        //TODO: Implement password recovery
    }

    /**
     * Log user with its login or e-mail and password
     *
     * @return boolean is login successful
     */
    public function logUser(): bool
    {
        if ($this->isLogged) {
            return true;
        }

        // database query
        $data = $this->database->select('accounts', [
            '[>]carriers' => [
                'carrierID' => 'carrierID',
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
            'carrier' => [
                'carriers.carrierID',
                'carriers.carrierName',
                'accounts.accountWorkStatus',
            ],
        ], [
            'AND' => [
                'OR'                          => [
                    'accounts.accountLogin[=]' => $this->userLogin,
                    'accounts.accountEmail[=]' => $this->userLogin,
                ],
                'accounts.accountPassword[=]' => $this->userPassword,
                'accounts.accountActive[=]'   => true,
            ],
        ]);

        // empty array evaluates to false
        if ($data) {
            $this->isLogged = true;

            // set new last login time in database
            $this->updateLLT($data[0]['account']['accountID']);

            // setting user details as class property
            $this->userData = $data[0];


            // freeing memory from unnessesary stuff
            $this->userLogin = null;
            $this->userPassword = null;
            return true;
        }

        $this->isLogged = false;
        return false;
    }

    /**
     * Updates logged user last login time
     *
     * @param integer $accountID logged user ID
     */
    protected function updateLLT($accountID): void
    {
        $date = date('Y-m-d H:i:s');

        $this->database->update('accounts', [
            'accountLastLoginTime' => $date,
        ], [
            'accountID[=]' => $accountID,
        ]);
    }

    /**
     * Check if database with user data works correctly
     *
     * @return bool true if exist, false if not
     */
    public function isDatabaseConnection(): bool
    {
        if ($this->database) {
            return true;
        }
        return false;
    }

    /**
     * returns true if user is logged, false if not, null if user s not created
     *
     * @return boolean|null
     */
    public function isLogged(): ?bool
    {
        return $this->isLogged;
    }

    /**
     * Returns array with user details
     *
     * @return array
     */
    public function getUserData(): array
    {
        return $this->userData;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return [
            'userData',
            'isLogged',
        ];
    }

    /**
     * Tasks to do on unserialize
     */
    public function __wakeup()
    {
        $this->database = DatabaseFactory::getInstance();
    }

}