<?php

if (!isset($_SESSION['User']) or !$_SESSION['User']->isLogged()) {
    // if user is not logged in, redirect to login
    header('Location: /login');
}
// authentication of allowation

$userData = $_SESSION['User']->getUserData();
print_r($userData);

return [
    'accinfo' => [
        'name'    => $userData['name'],
        'surname' => $userData['surname'],
    ],
];