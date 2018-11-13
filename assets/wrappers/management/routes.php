<?php

use DBLS\Controller\Base\Route;
use DBLS\Exceptions\ElementNotFoundException;
use DBLS\Exceptions\ValidateException;
use DBLS\Model\RouteData;

$ret = [];
$Route = new Route();


// DISPLAY

if (!empty(ROUTER[1]) and ROUTER[1] == 'add') {
    // ADD SCREEN
    if (isset($_POST['submit_add'])) {
        try {
            $RouteData = new RouteData($_POST['kbs'], $_POST['maxspeed'], $_POST['name'], $_POST['length']);
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

    // update data if form submitted
    if ($_POST['submit_edit']) {
        try {
            $RouteData = $RouteData = new RouteData($_POST['kbs'], $_POST['maxspeed'], $_POST['name'],
                $_POST['length']);
            // check if changes saved successfully
            if ($Route->update($_POST['kbs'], $RouteData)) {
                $ret['good'] = 'Changes saved succesfully';
            } else {
                $ret['error'] = 'Uncatched error happened.';
            }
        } catch (ValidateException $e) {
            $ret['error'] = $e->getMessage();
        } catch (ElementNotFoundException $e) {
            $ret['error'] = 'KBS number change is impossible.';
        }
    }

    // retrieve data
    try {
        $RouteData = $Route->read(ROUTER[2]);
        $ret['form'] = $RouteData;
    } catch (ElementNotFoundException $e) {
        $ret['error'] = $e->getMessage();
    } finally {
        $ret['window'] = 'edit';
    }

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