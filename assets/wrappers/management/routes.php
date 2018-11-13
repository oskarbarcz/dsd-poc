<?php

use DBLS\Controller\Base\Route;
use DBLS\Exceptions\ValidateException;
use DBLS\Model\RouteData;

$ret = [];


// DISPLAY

if (!empty(ROUTER[1]) and ROUTER[1] == 'add') {
    // ADD SCREEN
    if (isset($_POST['submit_add'])) {
        try {
            $RouteData = new RouteData($_POST['kbs'], $_POST['maxspeed'], $_POST['name'], $_POST['length']);
            $Route = new Route();
            if ($Route->create($RouteData)) {
                $ret['good'] = true;
            } else {
                $ret['error'] = 'Uncatched error occured, try again later.';
            }


        } catch (ValidateException $e) {
            $ret['error'] = $e->getMessage();
        }

    }
    $ret['window'] = 'add';
} elseif (!empty(ROUTER[1]) and ROUTER[1] == 'details' and (!empty(ROUTER[2]) or (int)ROUTER[2] === 0)) {
    // DETAIL SCREEN
    if (!is_numeric(ROUTER[2])) {
        // save from situation when ID is string
        header('Location: /routesmanagement');
    }/*
     * TODO
     *
     *
     */


    $ret['window'] = 'details';
    echo 'details';
} elseif (!empty(ROUTER[1]) and ROUTER[1] == 'edit' and (!empty(ROUTER[2]) or (int)ROUTER[2] === 0)) {
    // EDIT SCREEN
    if (!is_numeric(ROUTER[2])) {
        // save from situation when ID is string
        header('Location: /routesmanagement');
    }
    /*
     * TODO
     *
     *
     */


    $ret['window'] = 'details';
    echo 'edit';
} elseif (!empty(ROUTER[1]) and ROUTER[1] == 'delete' and (!empty(ROUTER[2]) or (int)ROUTER[2] === 0)) {
    // DELETE SCREEN
    if (!is_numeric(ROUTER[2])) {
        // save from situation when ID is string
        header('Location: /routesmanagement');
    }
    /*
     * TODO
     *
     *
     */


    $ret['window'] = 'delete';
    echo 'edit';
} else {
    // UNIVERSAL SCREEN WITH TRACK LIST
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