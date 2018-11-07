<?php

use DBLS\Controller\Base\Route;

$userData = $_SESSION['User']->getUserData();


$Route = new Route();

return [
    // Account box data
    'account' => [
        'name'       => $userData['account']['accountName'],
        'surname'    => $userData['account']['accountSurname'],
        'login'      => $userData['account']['accountLogin'],
        'carrier'    => $userData['carrier']['carrierName'],
        'workStatus' => ucfirst($userData['carrier']['accountWorkStatus']),
    ],
    'routes'  => $Route->readAll(),
];