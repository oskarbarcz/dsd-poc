<?php
if (!isset($_SESSION['User']) or !$_SESSION['User']->isLogged()) {
    // if user is not logged in, redirect to login
    header('Location: /login');
}
// authentication of allowation

$userData = $_SESSION['User']->getUserData();

return [
    // Account box data
    'account' => [
        'name'       => $userData['account']['accountName'],
        'surname'    => $userData['account']['accountSurname'],
        'login'      => $userData['account']['accountLogin'],
        'carrier'    => $userData['carrier']['carrierName'],
        'workStatus' => ucfirst($userData['carrier']['accountWorkStatus']),
    ],
];