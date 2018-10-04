<?php

use DBLS\Controller\User;
use DBLS\Model\LoginData;

if (isset($_SESSION['User']) and ($_SESSION['User'] instanceof User) and $_SESSION['User']->logUser()) {
    header('Location: /panel');
}

if (isset($_POST['login'])) {
    try {
        $data = new LoginData($_POST['login'], $_POST['password'], true);
        $_SESSION['User'] = new User($data);
        if ($_SESSION['User']->logUser()) {
            header('Location: /panel');
        } else return [
            'windowTitle' => 'Wrong data occured',
            'error'       => 'User with this login or email and password does not exists',
        ];
    } catch (Exception $exception) {
        return [
            'windowTitle' => 'Unknown login error',
            'error'       => 'Unknown error occured, try again later',
        ];
    }

}

return ['windowTitle' => 'Log in DBLS'];