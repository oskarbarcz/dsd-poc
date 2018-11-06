<?php

use DBLS\Controller\Maintenance\TrackObjectCategory;

$userData = $_SESSION['User']->getUserData();

$TrackObjectCategory = new TrackObjectCategory();
return [
    // Account box data
    'account' => [
        'name'       => $userData['account']['accountName'],
        'surname'    => $userData['account']['accountSurname'],
        'login'      => $userData['account']['accountLogin'],
        'carrier'    => $userData['carrier']['carrierName'],
        'workStatus' => ucfirst($userData['carrier']['accountWorkStatus']),
    ],
    // Types of objects for select box
    'types'   => $TrackObjectCategory->readAll(),
];