<?php

use DBLS\Controller\User;
use DBLS\Model\LoginData;

if (isset($_POST['login'])) {
    try {
        $data = new LoginData($_POST['login'], $_POST['password'], true);
        $_SESSION['User'] = new User($data);
        if ($_SESSION['User']->logUser()) {
            header('Location: /panel');
        } else return [
            'error' => 'User with this login or email and password does not exists',
        ];
    } catch (Exception $exception) {
        return [
            'error' => 'Unknown error occured, try again later',
        ];
    }

}

return [];