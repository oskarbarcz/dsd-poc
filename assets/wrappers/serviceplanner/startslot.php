<?php

if (!isset($_SESSION['User']) or !$_SESSION['User']->isLogged()) {
    // if user is not logged in, redirect to login
    header('Location: /login');
}
// authentication of allowation

$userData = $_SESSION['User']->getUserData();

return [
    'account' => [
        // Set datas on Profile box
        'name'       => $userData['account']['accountName'],
        'surname'    => $userData['account']['accountSurname'],
        'login'      => $userData['account']['accountLogin'],
        'company'    => $userData['company']['companyName'],
        'workStatus' => ucfirst($userData['company']['accountWorkStatus']),
    ],
];