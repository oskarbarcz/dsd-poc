<?php

use DBLS\Controller\Base\Route;

$ret = [];


if (isset(ROUTER[1]) and ROUTER[1] == 'add') {
    $ret['window'] = 'add';

    if (isset($_POST['submit_add'])) {
        echo 'submitted';

        $ret['good'] = true;
        $ret['window'] = 'none';
    }


} else {
    $ret['window'] = 'none';
}

$userData = $_SESSION['User']->getUserData();
$Route = new Route();


$ret += [
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

return $ret;