<?php

use DBLS\Controller\Maintenance\TrackObjectCategory;

$userData = $_SESSION['User']->getUserData();

$TrackObjectCategory = new TrackObjectCategory();
print_r($TrackObjectCategory->readAll());
die;
return [
    // Account box data
    'account' => [
        'name'       => $userData['account']['accountName'],
        'surname'    => $userData['account']['accountSurname'],
        'login'      => $userData['account']['accountLogin'],
        'carrier'    => $userData['carrier']['carrierName'],
        'workStatus' => ucfirst($userData['carrier']['accountWorkStatus']),
    ],
    'types'   => $TrackObjectCategory->readAll(),
];